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

3) Assign driver: http://localhost:8080/api/vehicles/assign
Remember to add some vehicles first
Body json example:
{
    "driverId": 1,
    "vehicleId": 2
}

Preloaded drivers:

<table><tr><th colspan="3">SELECT id, name, surname<br>FROM logistic.driver</th></tr><tr><th>id</th><th>name</th><th>surname</th></tr><tr class="odd"><td>1</td><td>Adam</td><td>Adamski</td></tr>
<tr><td>2</td><td>Bob</td><td>Bobowski</td></tr>
<tr class="odd"><td>3</td><td>Cesar</td><td>Cesarski</td></tr>
<tr><td>4</td><td>Derek</td><td>Derecki</td></tr>
<tr class="odd"><td>5</td><td>Evan</td><td>Evanski</td></tr>
</table>

4) Unassign driver: http://localhost:8080/api/vehicles/unassign
Remember to add some vehicles first
Body json example:
{
    "driverId": 1,
    "vehicleId": 2,
    "distance": 1000
}
