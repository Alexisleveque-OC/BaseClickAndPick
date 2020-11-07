<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Bill;
use App\Entity\Category;
use App\Entity\Meal;
use App\Entity\Order;
use App\Entity\OrderLine;
use App\Entity\OrderStatut;
use App\Entity\Restaurant;
use App\Entity\SellTo;
use App\Entity\Token;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $orderStatut0 = new OrderStatut();
        $orderStatut0->setValue("En attente");
        $manager->persist($orderStatut0);
        $orderStatut1 = new OrderStatut();
        $orderStatut1->setValue("a préparé");
        $manager->persist($orderStatut1);
        $orderStatut2 = new OrderStatut();
        $orderStatut2->setValue("Retiré");
        $manager->persist($orderStatut2);

        $sellTo0 = new SellTo();
        $sellTo0->setValue("unité");
        $manager->persist($sellTo0);
        $sellTo1 = new SellTo();
        $sellTo1->setValue("poids");
        $manager->persist($sellTo1);
        $sellTo2 = new SellTo();
        $sellTo2->setValue("taille");
        $manager->persist($sellTo2);
        $sellTo3 = new SellTo();
        $sellTo3->setValue("autre");
        $manager->persist($sellTo3);

        $meals = [];

        for ($j = 0; $j < 5; $j++) {
            $category = new Category();
            switch ($j) {
                case 0:
                    $category->setName('Entrée');
                    break;
                case 1:
                    $category->setName('Plat');
                    break;
                case 2:
                    $category->setName('Dessert');
                    break;
                case 3:
                    $category->setName('Boisson');
                    break;
                default:
                    $category->setName('Autre');
                    break;
            }
            $manager->persist($category);


            for ($k = 0; $k < 5; $k++) {
                $meal = new Meal();
                $meal->setName(sprintf($category->getName() . '%d', $k))
                    ->setPrice("1.50")
                    ->setCategory($category);
                if ($j == 0 || $j == 3) {
                    $meal->setSellTo($sellTo0);
                } elseif ($j == 1) {
                    $meal->setSellTo($sellTo1);
                } elseif ($j == 2) {
                    $meal->setSellTo($sellTo2);
                } else {
                    $meal->setSellTo($sellTo3);
                }
                $meals [] = $meal;
                $manager->persist($meal);
            }
        }
        for ($i = 0; $i < 5; $i++) {
            $address = new Address();
            $address->setAddress($faker->streetAddress)
                ->setZipCode(intval($faker->postcode))
                ->setCity($faker->city);
            $manager->persist($address);

            if ($i == 0) {

                $restaurant = new Restaurant();
                $restaurant->setName('le restau de toto')
                    ->setDescription('c\'est le restau de toto')
                    ->setEmail('contact@toto.fr')
                    ->setAddress($address);

                $manager->persist($restaurant);

                $token = new Token();

                $admin = new User();
                $admin->setUsername('Admin');
                $admin->setPassword('admin');
                $hash = $this->encoder->encodePassword($admin, $admin->getPassword());
                $admin->setPassword($hash);
                $admin->setEmail('admin@gmail.com');
                $admin->setTel(intval($faker->phoneNumber));
                $admin->setCreatedAt(new DateTime());
                $admin->setRoles(['ROLE_ADMIN']);
                $admin->setAddress($address);
                $admin->setRestaurant($restaurant);
                $admin->setValidated(true);
                $admin->setToken($token);

                $token->setUser($admin);
                $manager->persist($token);
                $manager->persist($admin);
            }
            else {
                $token = new Token();

                $user = new User();
                $user->setUsername(sprintf('user%d', $i));
                $user->setPassword('coucou');
                $hash = $this->encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($hash);
                $user->setEmail(sprintf('user%d@gmail.com', $i));
                $user->setTel(intval($faker->phoneNumber));
                $user->setCreatedAt(new DateTime());
                $user->setRoles(['ROLE_USER']);
                $user->setAddress($address);
                $user->setValidated(true);
                $user->setToken($token);

                $token->setUser($user);
                $manager->persist($token);
                $manager->persist($user);

                for ($m = 0; $m < mt_rand(1, 10); $m++) {
                    $order = new Order();
                    $bill = new Bill();

                    $order->setCreatedAt(new DateTime())
                        ->setUser($user);

                    $bill->setCreatedAt(new DateTime())
                        ->setUser($user)
                        ->setOrderId($order);

                    switch ($m) {
                        case ( 0 || 1):
                            $bill->setPayment(true);
                            $order->setOrderStatut($orderStatut2)
                                ->setBill($bill)
                                ->setValidatedAt(new DateTime());
                            break;
                        case 2:
                            $bill->setPayment(true);
                            $order->setOrderStatut($orderStatut1)
                                ->setBill($bill)
                                ->setPickedTo(new DateTime());
                            break;
                        default:
                            $bill->setPayment(false);
                            $order->setOrderStatut($orderStatut0);
                            break;
                    }
                    $manager->persist($order);
                    $manager->persist($bill);
                    for($n = 0; $n < mt_rand(0,8); $n++){
                        $orderLine = new OrderLine();
                        $orderLine->setQuantity(mt_rand(1,20))
                            ->setMeal($meals[(mt_rand(1, count($meals)-1))])
                            ->setOrderId($order);
                        $manager->persist($orderLine);
                    }
                }
            }
        }

        $manager->flush();
    }
}
