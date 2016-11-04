# Sendmode
Simple PHP library to help leverage the Sendmode API. Sendmode are a 100% Irish owned, multi-award winning Bulk Text provider.

The Sendmode library features the following functionality
- Send SMS (with/without schedule)
- Send Batch SMS (with/without schedule)
- Get Balance
- Get Delivery Report

Please visit [Sendmode](http://www.sendmode.com/) for more details of their services.

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
$result = $sms->send($phonenumber, $message);
// API response is returned as a SimpleXML object in $result.
```

## Usage

### Instantiation
Class Instantiation requires a Sendmode username, password, Sender ID with an optional return format.
```php
$username=''; // Your Sendmode Username.
$password=''; // Your Sendmode Password.
$senderid=''; // Sender ID SMS that is displayed to recipients.
$format='json|array'; // Optional return format. Default is SimpleXML object.

// Instantiate the class
$sms = new Sendmode($username, $password, $senderid, $format);
```

### Send a single SMS immediately
Sending a SMS immediately via the send() method.
The Customer ID is an optional argument.
```php
// Instantiate the class
$sms = new Sendmode($username, $password, $senderid);

// Send a single SMS
$phonenumber=''; // Phone number in the correct format.
$message=''; // Message to send.
$customerid=''; // Optional message UID used to track delivery reports.

$result = $sms->send($phonenumber, $message, $customerid);
// API response is returned as a SimpleXML object in $result.
```

### Send a single SMS at a scheduled time
Sending a SMS at a scheduled time of your choosing via the send() method. The Customer ID is an optional argument. Both the date & time arguments are required.
```php
// Instantiate the class
$sms = new Sendmode($username, $password, $senderid);

// Send Scheduled SMS
$phonenumber=''; // Phone number in the correct format.
$message=''; // Message to send.
$customerid=''; // Optional message UID used to track delivery reports.
$date=''; // in d/m/Y e.g. Feb 1st 2016 = 01/02/2016.
$time=''; // in H:i e.g. 1:15PM = 13:15.

$result = $sms->send($phonenumber, $message, $customerid, $date, $time);
// API response is returned as a SimpleXML object in $result.
```

### Send SMS to multiple recipients immediately
Sending a SMS immediately via the sendbatch() method.
Phone numbers should be an array of correctly formatted numbers.
```php
// Instantiate the class
$sms = new Sendmode($username, $password, $senderid);

// Send Scheduled SMS
$phonenumbers=array(); // Array of Phone numbers in the correct format.
$message=''; // Message to send.

$result = $sms->sendbatch($phonenumber, $message);
// API response is returned as a SimpleXML object in $result.
```

### Send SMS to multiple recipients at a scheduled time
Sending a SMS to multiple recipients at a scheduled time of your choosing via the sendbatch() method. Phone numbers should be an array of correctly formatted numbers. In order to schedule the delivery both the date & time arguments are required.
```php
// Instantiate the class
$sms = new Sendmode($username, $password, $senderid);

// Send Scheduled SMS to multiple recipients.
$phonenumbers=array(); // Array of Phone numbers in the correct format.
$message=''; // Message to send.
$date=''; // in d/m/Y e.g. Feb 1st 2016 = 01/02/2016.
$time=''; // in H:i e.g. 1:15PM = 13:15.

$result = $sms->sendbatch($phonenumber, $message, $customerid, $date, $time);
// API response is returned as a SimpleXML object in $result.
```

### Retrieving a delivery report 
You can retrieve the delivery status of a SMS via the getdeliveryreport() method using the UID (customerID) defined at the time of sending the SMS.

```php
// Instantiate the class
$sms = new Sendmode($username, $password, $senderid);

$customerid=''; // Your UID Customer ID used in the original send request.

$result = $sms->getdeliveryreport($customerid);
// API response is returned as a SimpleXML object in $result.
```

### Retrieving your account balance
Your account balance (SMS credits) can be retrieved via the getbalance() method.

```php
// Instantiate the class
$sms = new Sendmode($username, $password, $senderid);

$result = $sms->getbalance();
// API response is returned as a SimpleXML object in $result.
```
## License
Licensed under GPL v.3 [(tldr)](https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3))