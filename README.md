# Cancer Research UK Symfony Test

# Requirements

- PHP >=8.2
- Composer 2

# Running the project

- `composer install` from project root
- run `symfony server:start`
- navigate to http://localhost:8000/forecast

# Running the tests

- `php bin/phpunit`

---

## Notes

- You have been tasked with creating a Symfony app to act as a caching layer between the Open Meteo API and the employee dashboard.

I would use file caching as it is a simple solution. Downsides of my approach could be the I/O overhead of using the file system.
If throughput was a concern, utilising memcached or redis is a great option, or we could use a database adapter.
You may also serve stale information (ie. If the API content would change within the 5 minute TTL). 

For the PHPUnit component of the test, I wasn't sure what was worth testing since I'm using mostly Symfony functionality. 
I worked on implementing some of these tests, but didn't think it was worth submitting.

One test could manually delete the cache file and verify that data is retrieved from the API as expected. 
Another test could check cache and wait 5 minutes to verify the cache has been updated. 
You could test what happens if the API was down temporarily; perhaps we do not want to clear cache in that scenario. 
