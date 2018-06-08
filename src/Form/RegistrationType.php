<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 08.06.18
 * Time: 20:11
 */

namespace App\Form;

use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    }


    public function getParent()
    {
        return RegistrationFormType::class;

    }

}