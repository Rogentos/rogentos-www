<?php
/*
 *      class.login.php
 *      Copyright 2011 Victor Nitu <victor@debian-linux.ro>
 */

require_once 'config.php';

class logmein {

    //tabela de useri
    var $user_table = 'users';		//numele tabelei de UTILIZATORI
    var $group_table = 'app_userclasses';		//numele tabelei de GRUPURI
    var $user_column = 'username';		//NUMELE de utilizator
    var $pass_column = 'password';		//PAROLA retinuta
    var $user_group = 'classname';			//GRUPUL utilizatorului
    var $nume_column = 'user_nume';		//NUMELE real al utilizatorului
    var $prenume_column = 'user_prenume';		//PRENUMELE real al utilizatorului
    //var $perms_column = 'perms';		//campul cu PERMISIUNILE utilizatorului, ca array serializat

    //criptare
    var $encrypt = true;				//TRUE pentru a activa criptarea MD5 a parolei
 
    //conectarea la baza de date
    function dbconnect(){
        mysql_connect(dbHost, dbUser, dbPass) or die ('Unable to connect to the database');
        mysql_select_db(dbName) or die ('Unable to select database!');
        return;
    }

    public function __construct($hostname=dbHost,$database=dbName,$username=dbUser,$password=dbPass) {
        $this->hostname_logon = (isset($hostname) ? $hostname : dbHost);
        $this->database_logon = (isset($database) ? $database : dbName);
        $this->username_logon = (isset($username) ? $username : dbUser);
        $this->password_logon = (isset($password) ? $password : dbPass);
    }


    //functia de login
    function login($table, $username, $password){
        //conectare la DB
        $this->dbconnect();
        //verifica daca numele tabelei e definit
        if($this->user_table == ""){
            $this->user_table = $table;
        }
        //verifica daca foloseste MD5
        if($this->encrypt == true){
            $password = md5($password);
        }
        //executa login via qry() pentru a preveni MySQLi
        //$result = $this->qry("SELECT * FROM ".$this->user_table." NATURAL JOIN ".$this->group_table." WHERE ".$this->user_column."='?' AND ".$this->pass_column." = '?' ORDER BY groupname;" , $username, $password);
        $result = $this->qry("SELECT * FROM ".$this->user_table." WHERE ".$this->user_column."='?' AND ".$this->pass_column." = '?';" , $username, $password);
        $row=mysql_fetch_assoc($result);
        if($row != "Error"){
        //if(count($row)>0){
            if($row[$this->user_column] !="" && $row[$this->pass_column] !=""){
                //register sessions
                //se pot adauga sesiuni aditionale daca e nevoie
                $_SESSION['loggedin'] = $row[$this->pass_column];
                //username se retine in sesiune
                $_SESSION['username'] = $row[$this->user_column];
                //usergroup e optional
                $_SESSION['usergroup'] = $row[$this->user_group];
                $_SESSION['user_nume'] = $row[$this->nume_column];
                $_SESSION['user_prenume'] = $row[$this->prenume_column];
                $_SESSION['perms'] = $row[$this->perms_column];
                return true;
            }else{
                session_destroy();
                return false;
            }
        }else{
            return false;
        }
 
    }
 
    //Prevenirea SQLi printr-o functie custom de interogat DB
    function qry($query) {
      $this->dbconnect();
      $args  = func_get_args();
      $query = array_shift($args);
      $query = str_replace("?", "%s", $query);
      $args  = array_map('mysql_real_escape_string', $args);
      array_unshift($args,$query);
      $query = call_user_func_array('sprintf',$args);
      $result = mysql_query($query) or die(mysql_error());
          if($result){
            return $result;
          }else{
             $error = "Error";
             return $result;
          }
    }
 
    //functia de logout
    function logout(){
        session_destroy();
        return;
    }
 
    //verifica daca vizitatorul este logat
    function logincheck($logincode, $user_table, $pass_column, $user_column){
        //conectare la DB
        $this->dbconnect();
        //verifica daca parola este configurata in parametrii clasei
        if($this->pass_column == ""){
            $this->pass_column = $pass_column;
        }
        if($this->user_column == ""){
            $this->user_column = $user_column;
        }
        if($this->user_table == ""){
            $this->user_table = $user_table;
        }
        //executa query
        $result = $this->qry("SELECT * FROM ".$this->user_table." WHERE ".$this->pass_column." = '?';" , $logincode);
        $rownum = mysql_num_rows($result);
        //returneaza true daca vizitatorul e logat si false daca nu
            if($rownum > 0){
                return true;
            }else{
                return false;
            }
    }
}
?>