
Need to implement Symfony3 bundle for getting JSON-encoded locations data stored in predefined format.
Acceptance criteria
1. Client should be defined as a service class in a bundle config;
2. Client should utilize CURL as a transport layer (can rely upon any third-party bundle however should be implemented as a separate class/package);
3. Properly defined exceptions should be thrown on CURL errors, malformed JSON response and error JSON response;
4. Resulting data should be fetched as an array (or other collection) of properly defined PHP objects.

`
JSON response format
{
   “data”: {
       “locations”: [
           {
               “name”: “Eiffel Tower”,
               “coordinates”: {
                  “lat”: 21.12,
                   “long”: 19.56
               }
           },
           ...
       ]
   },
   “success”: true
}
JSON error response format
{
   “data”: {
       “message”: <string error message>,
       “code”: <string error code>
   },
   “success”: false
}
`