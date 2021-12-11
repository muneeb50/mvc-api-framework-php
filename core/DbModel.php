<?php


namespace app\core;


abstract class DbModel
{
    public string $id = '';
    public $createdBy;
    public $createdAt;
    public $modifiedBy;
    public $modifiedAt;

    public function __construct(){
        $this->createdBy = 'MMM';
        $this->createdAt = date('Y-m-d H:i:s');
        $this->modifiedBy = 'MMM';
        $this->modifiedAt = date('Y-m-d H:i:s');
    }

    abstract public static function tableName(): string;

    abstract public static function className(): string;

    public function primaryKey(): string
    {
        return 'id';
    }
    public function attributes()
    {
        return [];
    }

    private function getAllAttributes(){
        return array_merge(['id', 'createdBy', 'createdAt', 'modifiedBy', 'modifiedAt'], $this->attributes());
    }

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function validateInputCreate(){
        $this->id = uniqid();
    }

    public function save()
    {
        $this->validateInputCreate();
        $tableName = $this->tableName();
        $attributes = $this->getAllAttributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(",", $attributes) . ") 
                VALUES (" . implode(",", $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public static function prepare($sql): \PDOStatement
    {
        return Application::$app->db->prepare($sql);
    }

    public static function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

//        public function findOne($where)
//        {
//            $tableName = $this->tableName();
//            $attributes = array_keys($where);
//            $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
//            $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
//            foreach ($where as $key => $item) {
//                $statement->bindValue(":$key", $item);
//            }
//            $statement->execute();
//            return $statement->fetchObject($this->className());
//        }

    public function findAll($where = [])
    {
        $tableName = $this->tableName();
        $statement = '';
        if (count($where)>0){
            $attributes = array_keys($where);
            $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
            $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
            foreach ($where as $key => $item) {
                $statement->bindValue(":$key", $item);
            }
        }
        else{
            $statement = self::prepare("SELECT * FROM $tableName");
        }
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS, $this->className());
    }
}