<?php
class ImageFile
{
    
    public $name; //name of file
    public $type; //Mime of file
    public $size; //size of file
    public $tmp_name; //tmp_name of file
    public $x;
    public $y;
    function __construct($inputFile) //Array with name,type,size,tmp_name keys. Read from $_FILES["file"]
    {
        if(is_array($inputFile))
        {
            if(array_key_exists("name",$inputFile)&&array_key_exists("type",$inputFile)&&array_key_exists("size",$inputFile)&&array_key_exists("tmp_name",$inputFile))
            {
                
                if(is_uploaded_file($inputFile["tmp_name"]))
                {
                    $this -> name = $inputFile["name"];
                    $this -> type = $inputFile["type"];
                    $this -> size = $inputFile["size"];
                    $this -> tmp_name = $inputFile["tmp_name"];
                    
                    $imageSize = getimagesize ($this -> tmp_name);
                    if(!$imageSize)
                    {
                        throw new Exception('Image Conversion Failure');  
                    }
                    $this -> x = $imageSize[0];
                    $this -> y = $imageSize[1];
                    
                }
                else
                
                {
                    throw new Exception('uploaded file not found');
                }
            }
            else
            {
                throw new Exception('$inputFile Variable is not of the correct type');  
            }
        }
        else
        {
            throw new Exception('$inputFile Variable is not of the correct type');  
        }
    }
    
    function toGDImage() //returns image;
    {
        
        
        switch ( strtolower ($this -> type))
        {
            case "image/jpeg":
            case "image/pjpeg":
                return  imagecreatefromjpeg ($this -> tmp_name);
                break;
            case "image/png":
                return  imagecreatefrompng ($this -> tmp_name);
                break;
            case "image/gif":
                return  imagecreatefromgif($this -> tmp_name);
                break;
            default:
                throw new Exception('Image Conversion Failure');  
                return false;
                break;
        }
    }
    
   
    

}


?>