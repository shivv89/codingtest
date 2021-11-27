<?php


function walk($dir_dirnum,$action)
{//function to get direction with number or number code with direction
    if($action=='getnum'){
        if($dir_dirnum==1)
            $op='NORTH';
        else if($dir_dirnum==2)
            $op='EAST';
        else if($dir_dirnum==3)
            $op='SOUTH';
        else if($dir_dirnum==4)
            $op='WEST';
        
    }
    else if($action=='getdir'){
        if($dir_dirnum=="NORTH")
            $op=1;
        else if($dir_dirnum=="EAST")
            $op=2;
        else if($dir_dirnum=="SOUTH")
            $op=3;
        else if($dir_dirnum=="WEST")
            $op=4;
        
    }
    else if($action=="LRSTATUS"){
        if($dir_dirnum=="NORTH")
            $op="-|+";
        else if($dir_dirnum=="EAST")
            $op="+|-";
        else if($dir_dirnum=="SOUTH")
            $op="+|-";
        else if($dir_dirnum=="WEST")
            $op="-|+";
    }
    return $op;
}


if($argc==5)
{
    $x=$argv[1]; // x coordinate
   
    $y=$argv[2]; // y coordinate
    

    $direction=strtoupper($argv[3]); //one time
    

    $walkstr=strtoupper($argv[4]); //walkstring multiple instructions

    if(($x!="" && $y!="") && (!is_numeric($x) || !is_numeric($y)))
    {
        echo "X or Y Coordinates should be numeric";
        exit;
    }
    else
    {
        $walkstr=str_replace("W",",W",$walkstr);
        $walkstr=str_replace("L",",L",$walkstr);
        $walkstr=ltrim(str_replace("R",",R",$walkstr),',');
        $walkArr=explode(",",$walkstr);
		$lastvalue=end($walkArr);
		//$arrcnt=count($walkArr);

        print_r($walkArr); // print output Array([0] => R [1] => W2 [2] => L [3] => W4 [4] => R )
        //NE is positive
        //SW is negative
        $old_value="";
        foreach($walkArr as $value)
        {
            
            echo "$direction---- \n";
			
			if(substr($value,0,1)=='W'){
                $walkflag=substr($value,0,1);
                $steps=(int)substr($value,1);
            }

			if($direction=="NORTH" || $direction=="EAST" || $direction=="SOUTH" || $direction=="WEST")
            {
                $LRstatus=walk($direction,"LRSTATUS");
                $LRstatusArr=explode("|",$LRstatus);
                $leftstatus=$LRstatusArr[0];
                $rightstatus=$LRstatusArr[1];
                //exit;
            }
			if($leftstatus!="" || $rightstatus!=""){
				if($direction=="NORTH" || $direction=="SOUTH")
                {
                    if($rightstatus=="-"){
                        //echo "===$y->$steps===";
                        $x=$x-$steps;
                    }
                    elseif($rightstatus=="+"){
                        $x=$x+$steps;
                    }
                }
                elseif($direction=="EAST" || $direction=="WEST")
                {
                    if($rightstatus=="-"){
                        $y=$y-$steps;
                    }
                    elseif($rightstatus=="+"){
                        $y=$y+$steps;
                    }
                }

				$dir_number=walk($direction,"getdir");
				if($side=="L")
				{
					$dir_number=$dir_number-1;
					if($dir_number<0)
					{
						$dir_number=$dir_number+4;
					}
					
				}
				elseif($side=="R")
				{
					$dir_number=$dir_number+1;
					if($dir_number>3)
					{
						$dir_number=$dir_number-4;
					}
				}
				//echo $dir_number;
				$direction=walk($dir_number,"getnum");

			}

			
			
			if($value=="L" || $value=="R")
            	$side=$value;
            
			$rightstatus=$leftstatus="";
			
			//if last value will be left or right direction
			if($lastvalue=="R" || $lastvalue=="L"){
				$dir_number=walk($direction,"getdir");
				if($side=="L")
				{
					$dir_number=$dir_number-1;
					if($dir_number<0)
					{
						$dir_number=$dir_number+4;
					}
					
				}
				elseif($side=="R")
				{
					$dir_number=$dir_number+1;
					if($dir_number>3)
					{
						$dir_number=$dir_number-4;
					}
				}
				//echo $dir_number;
				$direction=walk($dir_number,"getnum");
			}
        }
    
    }
    echo "result--->  $x $y $direction";
}
else
{
    echo "Please enter the correct number of arguments";
}




?>