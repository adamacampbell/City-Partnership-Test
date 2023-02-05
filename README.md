# City-Partnership-Test
Repo for City Partnership Tech Test

# Environment / Setup
## 1. Docker
Full disclosure, I'm very new to setting up Docker so I may not have done this perfectly (I followed a tutorial). As far as I'm aware, you just have to have Docker (maybe Laravel?) installed and running, and then just run the following command in the laravel-api parent directory
```
./vendor/bin/sail up
```
## 2. Laravel .env
To allow for the best experience, it is recommended that you add the following two enviroment variabled to the laravel .env file.
```
FCA_AUTH_EMAIL=example@email.com
FCA_AUTH_KEY=example-fca-api-key
```
**THIS IS REQUIRED TO RUN** 
```
php artisan migrate --seed
```
## 3. Unit Tests
To run the unit tests, you must first setup the project (follow 1. Docker), and you **must have the FCA_AUTH_EMAIL and FCA_AUTH_KEY .env variables set**. Run the tests using the following command:
```
php artisan test
```
## 4. Environment
For reference, my environment was MacOS Ventura 13.1, using bash, and a homebrew installation of PHP Composer / Laravel Framework 9.50.2. I also installed Docker Desktop.
## 5. How to Run
There are two options, using the API directory or using the Web UI, both require that you follow instructions in 1. Docker.

If using the API directly, such as POSTMAN, you must either:

1. Send the following post request before making FRN checks: http://localhost/fca-creds?email=fca@email.com&key=your-fca-api-key
2. Set the FCA_AUTH_EMAIL and FCA_AUTH_KEY variables in the .env file (see .env.example for example), and then run
```
php artisan migrate --seed
```

If using the web interface, you can set the FCA_AUTH_EMAIL and FCA_AUTH_KEY .env variables or you can just enter your FCA API credentials through the basic web interface.

# Next Steps
## 1. Better UI
If given more time, I would have implemented a proper front end using something like Angular.
## 2. Analytics
The current system could be expanded upon to log checks, and use the data for analytics.
## 3. User System
The current implementation only allows for 1 storage of FCA API credentials, this could be upgraded to a multi user system.
## 4. Authentication
The current implementation has no authentication, this could be expanded upon and implemented if more security was needed for more sensitive actions.

# Assumtions
## 1. User Will Have Own FCA API Credentials
For development, I will store my FCA credentials as .env variables. However, users should use the configured API call to set up their FCA credentials (Email and API key).
## 2. Authentication for my API will not be required.
Due to the 'Simple' nature of the project, I have opted out of implementing authentication as it was not mentioned in the spec.
## 3. User will have Docker installed to host project.
Docker was mentionned in the spec, to allow for the project to be reusable. Full disclosure, I had to follow a tutorial to set this up as I'm fairly new to configuring Docker. Apologies in advance if I have done this incorrectly.
## 4. Use of '-' in URLs.
Everyone has their own preferences regarding the use of separators in URLs, I tend to use '-'. I'm not string minded on this and will use whatever other devs are strong minded on (less hassle), but Google do refer to the use of '-' as acceptable. [https://developers.google.com/search/docs/crawling-indexing/url-structure]

## 5. Caching Solution
I opted to go for a very basic cahing solution, using database as my CACHE_DRIVER. I chose database, as the spec mentioned the tool 'growing over time', and I thought this to be the more scalable approach. To enable caching, I thinkg the .env file will have to be modified to set CACHE_DRIVER=database.

## 6. Laravel Version
I Used Laravel Framework 9.50.2

## 7. Unit Tests
I added 5 unit tests, to cover varting API states. NOTE: I only added unit tests for the API routing, this is because I initially intended on only using API routing, but quickly added in a web route to get the web UI to work. Both behave identically (with slightly different response formats), so the unit tests should cover both.

## 8. Very Basic Front End
Due to the spec stating that I could use CLI, I assumed that the front end really wasn't of much significance. Therefore, my front end is extremly basic, as does not follow the best practices, to allow for more focus on the back end.