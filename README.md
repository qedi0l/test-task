# Template service

Stack: Laravel 11.3, Octane, Roadrunner 2025, PHP 8.3, PHPStan

## Setup
1. Clone repo
2. Create .env from .env.example
3. Build and run `make buildup`
4. PHPStan analyze `make analyze`

## Info
- App http://127.0.0.1:8080/
- API http://127.0.0.1:8080/api

RateLimiter set to 30k RPM for docker network and 300 RPM for api (per IP).

I have Swagger installed but huuuh idc. 

API doc: 

`POST http://127.0.0.1:8080/api/user/register`

Request body: 
- nickname - required, string, max:255
- avatar - required, image, mimes:jpg, 8mb





