<?php

namespace App\Controller;

use App\Entity\Driver;
use App\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class VehicleController extends AbstractController
{
    #[Route('/api/vehicles', name: 'vehicle_list')]
    public function list(EntityManagerInterface $entityManager): JsonResponse
    {
        $vehicles = $entityManager->getRepository(Vehicle::class)->findAll();
        $response = [];

        foreach($vehicles as $vehicle){
            $response[] = [
                'id' => $vehicle->getId(),
                'type' => $vehicle->getType(),
                'registrationNumber' => $vehicle->getRegistrationNumber(),
                'driver' => $vehicle->getCurrentDriver()?->getFullname(),
                'distance' => $vehicle->getDistance(),
                'capacity' => $vehicle->getCapacity() ?? "N/D"
            ];
        }

        return new JsonResponse([$response]);
    }


    #[Route('/api/vehicles/create', methods:["POST"], name: 'vehicle_createVehicle')]
    public function createVehicle(
        Request $request,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $newVehicle = new Vehicle($entityManager);
        $newVehicle->setType($data["type"]);
        $newVehicle->setDistance(0);
        $newVehicle->setDefaultRegistrationNumber();
        if ($data["type"]==="DOSTAWCZE") {
            $newVehicle->setCapacity($data["capacity"]);
        }

        $violations = $validator->validate($newVehicle);

        if (count($violations) > 0) {
            return new JsonResponse([
                'validationError' => (string) $violations
            ]);
        }

        $entityManager->persist($newVehicle);
        $entityManager->flush();

        return new JsonResponse([
            'id' => $newVehicle->getId(),
            'type' => $newVehicle->getType(),
            'registration' => $newVehicle->getRegistrationNumber()
        ]);
    }


    #[Route('/api/vehicles/assign', methods:["PATCH"], name: 'vehicle_assignDriver')]
    public function assignDriver(
        Request $request,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $driverId = $data['driverId'];
        $vehicleId = $data['vehicleId'];

        $vehicle = $entityManager->getRepository(Vehicle::class)->find($vehicleId);
        
        if (!$vehicle){
            return new JsonResponse([
                "Vehicle" => "Vehicle with id: $vehicleId does not exists"
            ]);
        }
        
        if($vehicle->getCurrentDriver()?->getId() > 0){
            return new JsonResponse([
                "Vehicle" => "Vehicle with id: $vehicleId is currently occupied."
            ]);
        }

        $driver = $entityManager->getRepository(Driver::class)->find($driverId);

        if (!$driver){
            return new JsonResponse([
                "Driver" => "Driver with id: $driverId does not exists"
            ]);
        }

        $vehicle->setCurrentDriver($driver);

        $entityManager->persist($vehicle);
        $entityManager->flush();

        return new JsonResponse([
            'id' => $vehicle->getId(),
            'currentDriver' => $vehicle->getCurrentDriver()->getId()
        ]);
    }


    #[Route('/api/vehicles/unassign', methods:["PATCH"], name: 'vehicle_unassignDriver')]
    public function unassignDriver(
        Request $request,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $driverId = $data['driverId'];
        $vehicleId = $data['vehicleId'];
        $distance = $data['distance'];

        $vehicle = $entityManager->getRepository(Vehicle::class)->find($vehicleId);
        
        if (!$vehicle){
            return new JsonResponse([
                "Vehicle" => "Vehicle with id: $vehicleId does not exists"
            ]);
        }
        
        if($vehicle->getCurrentDriver()->getId() !== $driverId){
            return new JsonResponse([
                "Vehicle" => "Vehicle with id: $vehicleId is currently occupied by someone else."
            ]);
        }

        $vehicle->setCurrentDriver(null);
        $currentDistance = $vehicle->getDistance();
        $vehicle->setDistance($currentDistance + $distance);

        $entityManager->persist($vehicle);
        $entityManager->flush();

        return new JsonResponse([
            'id' => $vehicle->getId(),
            'distance' => $vehicle->getDistance()
        ]);
    }
}
