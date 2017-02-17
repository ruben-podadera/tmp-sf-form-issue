# tmp-sf-form-issue
Tmp repository just to show an issue with symfony

No issue:
--------

With this code :

``` php
// src/AppBundle/Entity/Address.php
...
class Address
{
    public $id;
    
    public $zipCode;
}

// src/AppBundle/Form/AddressFieldsType.php
...
class AddressFieldsType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('zipCode', TextType::class, [
                'constraints' => [new NotBlank()]
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class
        ]);
    }
}
```

I submit empty data :
```
address[address_id]:
address[address_fields][zipCode]:
```

I get this :
OK

Issue:
------

With this code :

``` php
// src/AppBundle/Entity/Address.php
...
use Symfony\Component\Validator\Constraints as Assert;

class Address
{
    public $id;
    
    /**
     * @Assert\NotBlank()
     */
    public $zipCode;
}

// src/AppBundle/Form/AddressFieldsType.php
...
class AddressFieldsType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('zipCode', TextType::class);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class
        ]);
    }
}
```

I submit empty data :
```
address[address_id]:
address[address_fields][zipCode]:
```

I get this :
NOK
