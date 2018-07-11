
<?php

use SMSApi\Client;
use SMSApi\Api\SmsFactory;
use SMSApi\Exception\SmsapiException;

require_once 'SMSApi/autoload.php';

$client = Client::createFromToken('wygenerowany_token');

if (isset($_POST['submit']))
    // Check token ...
{
    echo "$_POST zainicjalizowany!!!!";
        //Lub wykorzystując login oraz hasło w md5
        //$client = new Client('login');
        //$client->setPasswordHash(md5('super tajne haslo'));

        $smsapi = new SmsFactory;
        $smsapi->setClient($client);

        try {
	        $actionSend = $smsapi->actionSend();

	        $actionSend->setTo($_POST['phone']);
	        $actionSend->setText($_POST['message']);
	        $actionSend->setSender('Info'); //Pole nadawcy, lub typ wiadomości: 'ECO', '2Way'

	        $response = $actionSend->execute();

	        foreach ($response->getList() as $status) {
		        echo $status->getNumber() . ' ' . $status->getPoints() . ' ' . $status->getStatus();
	        }
        }
        catch (SmsapiException $exception) {
            echo<<<END
                <div class="alert alert-dismissible alert-warning" id="dvi1">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4 class="alert-heading">Warning!</h4>
                    <p class="mb-0">
                        {$exception->getMessage()}
                    </p>
                </div>
END;
            // Clear $_POST array
            $_POST = array();
        }
}
else{
    echo<<<END
                <div class="alert alert-dismissible alert-success">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Well done!</strong> You successfully send message!
                </div>
END;
}
?>

<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="pl"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="css/boostrap.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <title>Bramka SMS</title>
</head>
<body>

    <div id="container">
        <h2>Your message</h2>
        <form action="SMS.php" method="POST">
            <div class="col-sm-6 col-centered">
                <div class="form-group">
                    <label for="message">Your message</label>
                    <textarea class="form-control" id="message" rows="3" required></textarea>
                </div>
            </div>
            <div class="col-sm-6 col-centered">
                <label class="col-form-label" for="phone">Phone number</label>
                <input type="number" class="form-control col-centered" placeholder="Phone number" id="phone" required />
            </div>
            <button type="submit" id="submit" class="btn btn-primary">Send SMS</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>
