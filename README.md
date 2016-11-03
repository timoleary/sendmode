# Sendmode
Simple PHP library to help leverage the Sendmode API. Sendmode are a 100% Irish owned, multi-award winning Bulk Text provider.

The Sendmode library features the following functionality
- Send SMS (with/without schedule)
- Send Batch SMS (with/without schedule)
- Get Balance
- Get Delivery Report

Please visit [Sendmode](https://www.sendmode.com/) for more details of their services.

## Installation

**Manual Install**
Include the `lib/sendmode.php` file in your project.
 
or 

**Automatic Install** via [Composer](https://packagist.org/packages/kreative/sendmode)
composer require kreative/sendmode

## Quick Start
Sending a SMS via the Sendmode API is as simple as
```php
// Instantiate the class
$sms = new Sendmode($username, $password, $senderid);

// Send SMS
$result = $sms->send($phonenumber,$message);
// API response is returned as a SimpleXML object in $result.
```

## License
F3-PYPL is licensed under GPL v.3