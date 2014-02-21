<!DOCTYPE html>
<html>

	<head>
		<title>Minecraft Server Status Checker</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	
    <?php
	
		$ip = 'ryanscpu';
		$customIP = $_GET['ip'];
		if($customIP != null){
		$ip = test_input($customIP);
		}	
        require __DIR__ . '/MinecraftQuery.class.php';

        $na = true;
        $Query = new MinecraftQuery( );

        try
        {
            $Query->Connect( $ip , 25565 );
            $Players = $Query->GetPlayers( );
        }
        catch( MinecraftQueryException $e )
        {
            echo $e->getMessage( );
            $na = false;
        }
		
		function test_input($data)
		{
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}		
    ?>
    
    <body>       

        <v class = "small">
            <?php 
                echo "Version: " .  $Query->GetInfo()[ 'Version' ];
            ?>
        </v>
        
        <m class = "small">
            <?php 
				$motd = $Query->GetInfo()[ 'HostName' ];
				$remove = "\n";
				$motd = str_replace($remove, ' ', $motd);
				$motd = preg_replace('/\xa7./','',$motd);
				$motd = filter_var($motd,FILTER_SANITIZE_SPECIAL_CHARS,FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH);
                echo "MOTD: " . $motd;
            ?>
        </m>
    
        <g class = "small">
            <?php 
                echo "Gamemode: " . $Query->GetInfo()[ 'GameType' ];
            ?>
        </g>
        
        <pl class = "small">
            <?php 
                echo "Plugins: ";
                if($Query->GetInfo()[ 'Plugins' ] == null){
                    if($na == true){
                        echo "n/a";
                    } 
                }
                else{
                    for($i=0; $i<count($Query->GetInfo()[ 'Plugins' ]); $i++){
                        echo $Query->GetInfo()[ 'Plugins' ][$i];               
                    }
                }
            ?>
        </pl>
        
        <ma class = "small">
            <?php 
                echo "Map: " . $Query->GetInfo()[ 'Map' ];
            ?>
        </ma>
        
        <pn class = "small">
            <?php 
                echo "Players: " . $Query->GetInfo()[ 'Players' ] . "/" . $Query->GetInfo()[ 'MaxPlayers' ];
            ?>
        </pn>
        
        <IP class = "small">
            <?php 
                echo "IP: " . $Query->GetInfo()[ 'HostIp' ];
            ?>
        </IP> 
        
        <s class = "small" style="text-decoration:none;">
            <?php 
                echo "Server Software: " . $Query->GetInfo()[ 'Software' ];
            ?>
        </s> 
 
        <op class = "big">
            <?php 
                echo "Players Online:";
            ?>
        </op>
        
        <p>
            <?php 
                for($i=0; $i<count($Players); $i++){
                    if($Query->GetInfo()[ 'Players' ] > 0){
                        echo "<img src=https://minotar.net/avatar/".$Players[$i]."/128.png>";
                    }
                }
            ?>
        </p>
        
        <pi>
            <?php 
                for($i=0; $i<count($Players); $i++){
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $Players[$i] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                }
            ?>
        </pi>         
        
        <rp  class = "invis">
            <?php 
                if($Query->GetInfo()[ 'RawPlugins' ] == null){
                    if($na == true){
                        echo "n/a";
                    }    
                }
                else{
                    echo $Query->GetInfo()[ 'RawPlugins' ];
                }          
            ?>
        </rp>
             
        <hp class = "invis">
            <?php 
                echo $Query->GetInfo()[ 'HostPort' ];
            ?>
        </hp>        
    </body>
</html>