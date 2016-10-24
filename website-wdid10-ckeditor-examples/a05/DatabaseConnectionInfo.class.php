<?phpnamespace wdid;
class DatabaseConnectionInfo {
    public function __construct( $host, $name, $user, $pass ){
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->name = $name;
        $this->charset = 'utf8';
    }
}