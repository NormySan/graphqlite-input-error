# GraphQLite Input Exception

## Requirements

- PHP 8.1
- Redis
- Symfony CLI

## Re-producing the error

1. Install dependencies with composer.
2. Start application with `symfony serve`.
3. Go to http://127.0.0.1:8000/ to get the API explorer.
4. Have the terminal open in the browser to be able to view the response.
5. Attempt to perform the "createFacility" or "updateFacility" mutations.