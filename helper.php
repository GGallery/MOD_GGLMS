<?php
defined('_JEXEC') or die;

class modgglmsHelper {
    private static $_attestati;
    private static $_corsi;

    public static function getAttestati() {
        try {

            $db = JFactory::getDbo();

            $user = JFactory::getUser();
            $userid = $user->get('id');


            $query = "SELECT DISTINCT
                c.corso, e.id
                FROM
                            #__quiz_r_student_quiz AS q
                Inner Join
                            #__gg_elementi AS e ON q.c_quiz_id = e.path
                Inner Join
                            #__gg_moduli AS m ON m.id = e.id_modulo
                Inner Join
                            #__gg_corsi AS c ON c.id = m.id_corso
                WHERE
                q.c_passed = 1
                AND
                e.elemento LIKE '%attestato%'
                AND
                c_student_id =".$userid;



            $db->setQuery($query);
            if (false === ($results = $db->loadAssocList()))

                throw new RuntimeException($db->getErrorMsg(), E_USER_ERROR);


            //  if(empty($results[1]))
            //   $out[]=$results;
            // else
            $out=$results;

            self::$_attestati = $out;

            return self::$_attestati;

        } catch (Exception $e) {
            return array();
        }
    }


    public function getCorsi() {
        try {

            $db = JFactory::getDbo();

            $user = JFactory::getUser();
            $userid = $user->get('id');


            $query = "SELECT

    corsi_abilitati

    FROM (
      SELECT
      c.corsi_abilitati, DATE_ADD(data_utilizzo,INTERVAL durata DAY) < NOW() AS scaduto
                      FROM #__gg_coupon as c
                      WHERE id_utente =".$userid."
                       AND c.abilitato = 1

                      ) as CP
where scaduto = 0 or scaduto is null";


            $db->setQuery($query);
            if (false === ($results = $db->loadAssocList()))

                throw new RuntimeException($this->_db->getErrorMsg(), E_USER_ERROR);

            // if(!$results[1])
            //  $out[]=$results;
            // else
            $out=$results;

            // in questa parte concateno in un unica stringa, affinchè possa poi passarla alla successiva query, tutti gli elemnti dell'array

            $abilitati='';       // dichiaro una stringa
            if($out[0])           //controllo la stringa non sia vuota

            {
                foreach($out as $listaidcorsi)
                    $abilitati.=",".$listaidcorsi['corsi_abilitati'];   //concateno la virgola con la stringa lista corsi
            }

            $abilitati=substr($abilitati, 1);

// Associo l'ID corso al nome per esteso
            $query = "SELECT
            *
          FROM
            #__gg_corsi as c
           where c.id in ($abilitati)";


            $db->setQuery($query);
            if (false === ($risultato = $db->loadAssocList()))
                throw new RuntimeException($this->_db->getErrorMsg(), E_USER_ERROR);

            self::$_corsi = $risultato;
            return self::$_corsi;

        }  catch (Exception $e) {
            return array();
        }
    }

    public static function getCorsiInScadenza(){

        try {
            $db = JFactory::getDbo();
            $user = JFactory::getUser();
            $userid = $user->get('id');
            $query = $db->getQuery(true);
            $query->select('anagrafica.id as id, anagrafica.id_event_booking as eb');
            $query->from('#__gg_report_users as anagrafica');
            $query->where('id_user='.$userid);
            $db->setQuery($query);
            $id_anagrafici=$db->loadObjectList();
            $result=[];
            foreach ($id_anagrafici as $anagrafico) {
                $query = $db->getQuery(true);
                $query->select('u.titolo as titolo, uc.stato as stato,IF(date(now())>DATE_ADD(u.data_fine, INTERVAL -30 DAY), IF(stato=0,1,0),0) as alert');
                $query->from('#__gg_view_stato_user_corso as uc');
                $query->join('inner', '#__gg_unit as u on uc.id_corso=u.id');
                $query->where('uc.id_anagrafica=' . $anagrafico->id);
                $db->setQuery($query);
                $array_corsi=$db->loadObjectList();

                if ($array_corsi==null){


                    $db = JFactory::getDbo();
                    $query = $db->getQuery(true);
                    $query->select('id,accesso');
                    $query->from('#__gg_unit');
                    $query->where('is_corso=1');

                    $db->setQuery($query);
                    $corsi_metodi=$db->loadObjectList();

                    foreach ($corsi_metodi as $metodo){

                        switch ($metodo->accesso) {

                            case 'iscrizioneeb':

                                if ($anagrafico->eb != null && $anagrafico->eb != 0) {
                                    $query = $db->getQuery(true);
                                    $query->select('titolo');
                                    $query->from('#__gg_unit');
                                    $query->where('id_event_booking=' . $anagrafico->eb . ' and id=' . $metodo->id);
                                    $db->setQuery($query);
                                    $titolo = $db->loadResult();

                                    if ($titolo != null){
                                        array_push($result, $titolo . ' stato: non iniziato');
                                        break 2;
                                    }
                                }

                                break ;
                            case 'gruppo':

                                $query_ = $db->getQuery(true);
                                $query_->select('u.titolo');
                                $query_->from('#__gg_usergroup_map as m ');
                                $query_->join('inner', '#__user_usergroup_map as um on m.idgruppo=um.group_id');
                                $query_->join('inner', '#__gg_report_users as anagrafica on um.user_id=anagrafica.id_user');
                                $query_->join('inner', '#__gg_unit as u on m.idunita=u.id');
                                $query_->where(' anagrafica.id=' . $anagrafico->id);
                                $db->setQuery($query_);
                                $titolo = $db->loadResult();

                                if ($titolo != null) {
                                    array_push($result, $titolo . ' stato: non iniziato');
                                    break 2;
                                }
                                break ;
                        }


                    }

                }else{
                    foreach ($array_corsi as $corso) {
                        if ($corso->stato==0 && $corso->alert==1)
                            array_push($result, $corso->titolo.' stato: non completo');
                    }
                }
            }

            return $result;
        }catch (Exception $e){

            echo $e->getMessage();
        }


    }

    public static function getUltimoArticolo($unit_id){

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('c.alias, c.titolo');
        $query->from('#__gg_contenuti as c');
        $query->join('inner', '#__gg_unit_map AS m ON c.id = m.idcontenuto');
        $query->join('inner', '#__gg_unit AS u ON m.idunita = u.id');
        $query->where('u.id = ' . $unit_id );
		$query->where('c.pubblicato = 1');
        $query->order('c.id desc');
        $query->setLimit('1');

        $db->setQuery($query);
        $contenuto=$db->loadObject();

        return $contenuto;
    }

    public static function normalizza_ore($v1)
    {
        $v2 = intval($v1) + 0.5;
        if ($v1 < $v2) return intval($v1);

        return $v1;
    }
}
