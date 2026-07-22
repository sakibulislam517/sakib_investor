<?php

$url = 'http://62.75.207.39:7790/sendtext?apikey=03080ee6db07c88e&secretkey=8034542d&callerID=1002_asb-00&toUser=01789295203&messageContent=teset sms';

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            
            $resp = curl_exec($curl);
            curl_close($curl);
            echo $resp;