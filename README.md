# LogisticTest

Make sure that You have 'make' installed.
To build and run project type 'sudo make install' in terminal.

Endpoints:
1) List Vehicles: http://localhost:8080/api/vehicles

2) Add vehicle: http://localhost:8080/api/vehicles/create
Body json example:
{
    "type": "MOTOR"
}
Allowed types:
- MOTOR
- OSOBOWE
- DOSTAWCZE

3)Assign driver: http://localhost:8080/api/vehicles/assign
Remember to add some vehicles first
Body json example:
{
    "driverId": 1,
    "vehicleId": 2
}

Preloaded drivers:
id  name    surname
1	  Adam	  Adamski
2	  Bob	    Bobowski
3	  Cesar	  Cesarski
4	  Derek	  Derecki
5	  Evan	  Evanski

4)Unassign driver: http://localhost:8080/api/vehicles/unassign
Remember to add some vehicles first
Body json example:
{
    "driverId": 1,
    "vehicleId": 2,
    "distance": 1000
}
