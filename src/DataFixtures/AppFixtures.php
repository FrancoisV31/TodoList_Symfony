<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Todo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        # liste pour mon sélecteur de catégories
        $categories = ['Professionnel','Personnel', 'Important'];
        #tableau pour enregistrer chaque objet de type Category
        $tabObjetsCategory = [];
        #boucle pour créer autant d'objets que de catégories dans la liste
        foreach($categories as $cat) {
            $category = new Category();
            $category->setName($cat);
            $manager->persist($category);
            array_push($tabObjetsCategory, $category);
            
        }
        #instance de type Todo
         $uneTodo = new Todo();
         $uneTodo 
                 -> setTitle('initialiser la Todo')
                 -> setContent('Alimenter la base de données avec un premier enregistrement')
                 -> setTodoFor(new \DateTime('Europe/paris'))
                 -> setCategory($tabObjetsCategory[0]);
                 #enregistre l'objet

        $manager->persist($uneTodo);
        #on finalise la fin de requêtes
        $manager->flush();
    }
}
