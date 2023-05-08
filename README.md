# Service QR-Detector

[![pipeline status](https://git.wki.ir/idpay/backend/qr-detector/badges/master/pipeline.svg)](https://git.wki.ir/idpay/backend/qr-detector/-/pipelines)
[![coverage report](https://git.wki.ir/idpay/backend/qr-detector/badges/master/coverage.svg)]()
[![Latest Release](https://git.wki.ir/idpay/backend/qr-detector/-/badges/release.svg)](https://git.wki.ir/idpay/backend/qr-detector/-/releases)

This project has been developed on [Laravel Framework](https://laravel.com/docs)

## Deploy

1. git clone git@git.wki.ir:idpay/backend/qr-detector.git
2. cd qr-detector
3. composer install --no-plugins --no-scripts
4. cp .env.example .env
5. php artisan key:generate
6. vim .env // update the variables names
7. php artisan optimize

## Test

- Inside the project root directory type the following:
  `php artisan test`

## APIs

#### Health

request:
```shell
curl -X GET http://qr-detector.local/health \
  -H 'Content-Type: application/json'
```

response:
```json
{
    "status":true
}
```

#### Version

request:
```shell
curl -X GET http://qr-detector.local/version \
  -H 'Content-Type: application/json'
```

response:
```json
{
    "tag":"v1.0.0",
    "commit":"ed558a5",
    "date":"2022-10-17T09:13:45+00:00",
    "service":"qr-detector"
}
```
