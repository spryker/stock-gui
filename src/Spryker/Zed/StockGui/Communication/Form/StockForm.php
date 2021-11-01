<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\StockGui\Communication\Form;

use Generated\Shared\Transfer\StockTransfer;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @method \Spryker\Zed\StockGui\Communication\StockGuiCommunicationFactory getFactory()
 */
class StockForm extends AbstractType
{
    /**
     * @var string
     */
    protected const BLOCK_PREFIX = 'stock';

    /**
     * @var string
     */
    protected const FIELD_ID_STOCK = 'idStock';

    /**
     * @var string
     */
    protected const FIELD_NAME = 'name';

    /**
     * @var string
     */
    protected const FIELD_IS_ACTIVE = 'isActive';

    /**
     * @var string
     */
    protected const FIELD_STORE_RELATION = 'storeRelation';

    /**
     * @var int
     */
    protected const FIELD_NAME_MAX_LENGTH = 256;

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return static::BLOCK_PREFIX;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'data_class' => StockTransfer::class,
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addIdStockField($builder)
            ->addNameField($builder)
            ->addIsActiveField($builder)
            ->addStoreRelationForm($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIdStockField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_ID_STOCK, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addNameField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_NAME, TextType::class, [
            'label' => 'Name',
            'constraints' => [
                new NotBlank(['normalizer' => 'trim']),
                new Length(['max' => static::FIELD_NAME_MAX_LENGTH]),
                $this->getFactory()->createStockNameUniqueConstraint(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIsActiveField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_IS_ACTIVE, ChoiceType::class, [
            'label' => 'Is this warehouse available?',
            'choices' => [
                'Yes' => true,
                'No' => false,
            ],
            'multiple' => false,
            'expanded' => true,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addStoreRelationForm(FormBuilderInterface $builder)
    {
        $builder->add(
            static::FIELD_STORE_RELATION,
            $this->getFactory()->getStoreRelationFormTypePlugin()->getType(),
            [
                'label' => 'Available in the following store(s)',
                'required' => false,
            ],
        );

        return $this;
    }
}
