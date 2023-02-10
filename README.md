# PHP OpenProvider REST API

PHP implementation for OpenProvider REST API 1.0.0-beta
https://docs.openprovider.com/doc/all

Keep in mind API is in Beta and might change.

## Setup

Setup variables in your `.env` or other configuration option you're using.
The `ApiHelper` class expects a `config()` function to exist.

```.env
OPENPROVIDER_USER=username@openprovider.cp
OPENPROVIDER_PASS=Sup3rs3cret4cc0untp455w0rd
```

## Usage

Example below shows how to change a record.

```php
use Openprovider\Api\ApiHelper;
use Openprovider\Api\Dns\ZoneService;
use Openprovider\Entities\Dns\Zone;
use Openprovider\Entities\Dns\ZoneRecord;

$client = ApiHelper::getClient();
$zone_api = new ZoneService($client);

$domain_name = "domain.tld";

try {
    // Try to retrieve zone
    $zone = $zone_api->get($domain_name);
} catch (Exception $ex) {
    // Exception, zone doesn't exist so lets create it
    $zone = new Zone();
    $zone->active = true;
    $zone->setType(Zone::TYPE_MASYER);
    $zone->setName($domain_name);
    $zone_api->create($zone);
}

// Create a CNAME www record to "domain.tld."
$www_record = new ZoneRecord();
$www_record->setName('www');
$www_record->setType(ZoneRecord::TYPE_CNAME);
$www_record->setValue($domain_name . '.');
$www_record->setTtl(ZoneRecord::TTL_15MIN);

// Replace all records
try {
    $add_records = [];
    $remove_records = [];
    $replace_records = [$www_record];
    $zone_api->update($zone, $add_records, $remove_records, $replace_records);
} catch (Exception $ex) {
    echo "Error when updating zone: ", $domain_name, PHP_EOL;
    echo $ex->getMessage();
}
```
