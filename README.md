# tmp-sf-form-issue
Tmp repository just to show an issue with symfony

Explanation:
------------

I have a 'complex' symfony form that let the user choose between an existing address or fill a new one. There are 3 form types:
- The [AddressFieldsType](https://github.com/ruben-podadera/tmp-sf-form-issue/blob/master/src/AppBundle/Form/AddressFieldsType.php), that handles the address fields like zipCode, etc.
- The [AddressIdType](https://github.com/ruben-podadera/tmp-sf-form-issue/blob/master/src/AppBundle/Form/AddressIdType.php), that let the user choose an existing Address in the database by entering its id. Yes this is not user friendly. Yes this is just here for explanation reasons, in the real case I have a select.
- The [AddressType](https://github.com/ruben-podadera/tmp-sf-form-issue/blob/master/src/AppBundle/Form/AddressType.php) that combines the two forms

The AddressType should get/set from/to an Address but its own form description does not match with the data so there is a [data transformer](https://github.com/ruben-podadera/tmp-sf-form-issue/blob/master/src/AppBundle/Form/AddressTypeTransformer.php) that converts an Address to the excepted data array format.


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

![](http://i.imgur.com/Ae5FjHPm.png)

-> This is correct, the constraint error is located next to the field causing the error

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

![](http://i.imgur.com/FZ7zW1wm.png)

-> not correct, the constraint error is on top of the form

Of course :
----------
In the real project I must use the annotated contraints because they are used by other forms.


