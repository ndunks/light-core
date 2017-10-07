<?php
namespace Light;
/**
* Magic Call
*/
class Magical
{
	/**
     * Auto get property. (get | set | add | has | clear | is)
     * with some validation before execution, this function to user action
     * 
     * call $obj->getName( $default_value_if_mising ) to get $obj->name;
     * call $obj->isName() to check $obj->name = true;
     * call $obj->hasName() to check isset($obj->name) || count($obj->name) > 0;
     * call $obj->clearName() to clear $obj->name = null || [];
     * call $obj->addName( $value ) to set $obj->name[] = $value;
     * 
     * call $obj->setName( $name ) to set $obj->name = $name;
     * call $obj->setNameLong( $name ) to set $obj->nameLong = $name;
     */
    public function __call(String $function, Array $arguments)
    {

        $call;
        $name;
        for($i = 2; $i < strlen($function); $i++)
        {
            $char = ord($function[$i]);
            //Check is uppercase A-Z, or number, or '_'
            if(    ($char >= 65 && $char <= 90) // A-Z
                || ($char >= 48 && $char <= 57) // 0-9
                || $char == 95 ) { // _
                $call = substr($function, 0, $i);
                $name = lcfirst( substr($function, $i) );
                break;
            }
        }
            
        if(empty($call) || empty($name))
            throw new \Exception("Invalid call");

        if(!property_exists($this, $name)){
            switch ( $call ) {
                case 'count':
                    return 0;
                    break;
                case 'get':
                    //return default value if not exists
                    return !empty($arguments) ? current($arguments) : null;
                    break;
                case 'has':
                case 'is':
                    return false;
                    break;
                default:
                    throw new Exception("Undefined $name on " . get_called_class());
                    break;
            }
        }


        switch ( $call ) {

            case 'count':
                return is_array($this->$name) ? count($this->$name) : null;
                break;

            case 'get':
                return is_null($this->$name) && !empty($arguments) ? current($arguments) : $this->$name;
                break;

            case 'has':
                return is_array($this->$name) ? count($this->$name) > 0 : isset($this->$name);
                break;
                
            case 'is':
                return $this->$name == true;
                break;

            case 'add':
                    if(empty($arguments))
                        throw new \Exception("Missing value when calling $function");

                    if(is_array($this->$name))
                        $this->$name[] = $arguments[0];
                    else{
                        if(is_string($this->$name))
                            $this->$name    .= $arguments[0];
                        elseif(is_numeric($this->$name))
                            $this->$name    += $arguments[0];
                        else
                            throw new \Exception("Not addable $name");
                    }
                break;

            case 'set':
            	$this->$name =  $value;

            case 'clear':
                $this->$name = is_array($this->$name) ? [] : null;
                break;
            
            default:
                throw new \Exception("Invalid call");
                break;
        }

    }
}