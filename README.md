# LogisticTest

Make sure that You have 'make' installed.
To build and run project type 'sudo make install' in terminal.

Endpoints:
1) List Vehicles: http://localhost:8080/api/vehicles

2) Add vehicle: http://localhost:8080/api/vehicles/create </br>
Body json example:</br>
{</br>
    "type": "MOTOR"</br>
}</br>
Allowed types:
- MOTOR
- OSOBOWE
- DOSTAWCZE

3) Assign driver: http://localhost:8080/api/vehicles/assign</br>
Remember to add some vehicles first</br>
Body json example:</br>
{</br>
    "driverId": 1,</br>
    "vehicleId": 2</br>
}</br>

Preloaded drivers:

<table><tr><th>id</th><th>name</th><th>surname</th></tr><tr class="odd"><td>1</td><td>Adam</td><td>Adamski</td></tr>
<tr><td>2</td><td>Bob</td><td>Bobowski</td></tr>
<tr class="odd"><td>3</td><td>Cesar</td><td>Cesarski</td></tr>
<tr><td>4</td><td>Derek</td><td>Derecki</td></tr>
<tr class="odd"><td>5</td><td>Evan</td><td>Evanski</td></tr>
</table>

4) Unassign driver: http://localhost:8080/api/vehicles/unassign</br>
Remember to add some vehicles first</br>
Body json example:</br>
{</br>
    "driverId": 1,</br>
    "vehicleId": 2,</br>
    "distance": 1000</br>
}</br>
