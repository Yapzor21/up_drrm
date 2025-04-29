<?php

class searchModel{
    private $pdo;
    
    public function __construct($pdo){
       $this->pdo=$pdo;
    }
   
    
    public function search($query){
        $stmt=$this->pdo->prepare("SELECT Report_Id, Disaster_Type, time_started, Date_Reported, assigned_team, Location, City FROM user_report WHERE Report_Id LIKE ? OR Disaster_Type LIKE ? OR assigned_team LIKE ? OR Location LIKE ? OR City LIKE ?");
        $searchTerm = "%$query%";
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function close(){

    }
}

?>