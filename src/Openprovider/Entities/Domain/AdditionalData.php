<?php

namespace Openprovider\Entities\Domain;

use Openprovider\Entities\AbstractEntity;

/**
 * @author Roy Arisse <support@perfacilis.com>
 * @copyright (c) 2020, Perfacilis
 */
class AdditionalData extends AbstractEntity
{
    public $abogado_acceptance = '';
    public $admin_sing_pass_id = '';
    public $ae_acceptance = '';
    public $allocation_token = '';
    public $auth_code = '';
    public $bank_acceptance = '';
    public $company_registration_number = '';
    public $customer_uin = '';

    /**
     * @var string[]
     */
    public $domain_name_variants = [];
    public $eligibility_type = '';
    public $eligibility_type_relationship = '';
    public $ftld_token = '';
    public $gay_donation_acceptance = '';
    public $gay_rights_protection_acceptance = '';
    public $id_number = '';
    public $id_type = '';
    public $idn_script = '';
    public $insurance_acceptance = '';
    public $intended_use = '';
    public $law_acceptance = '';
    public $legal_type = '';
    public $maintainer = '';
    public $membership_id = '';
    public $mobile_phone_number_verification = '';
    public $ngo_ong_eligibility_acceptance = '';
    public $ngo_ong_policy_acceptance = '';
    public $passport_number = '';
    public $rurf_blocked_domains = '';
    public $self_service = '';
    public $trademark = '';
    public $trademark_id = '';
    public $travel_acceptance = '';
    public $vat = '';
    public $verification_code = '';
    public $vote_acceptance = '';
    public $voto_acceptance = '';

    public function getSerializableFields(): array
    {
        return [
            'abogado_acceptance',
            'admin_sing_pass_id',
            'auth_code',
            'company_registration_number',
            'customer_uin',
            'customer_uin_doc_type',
            'domain_name_variants',
            'intended_use',
            'law_acceptance',
            'maintainer',
            'membership_id',
            'mobile_phone_number_verification',
            'ngo_ong_eligibility_acceptance',
            'ngo_ong_policy_acceptance',
            'passport_number',
            'vat',
            'verification_code',
        ];
    }

    public function propertyValueMap(): array
    {
        return [
            'customer_uin_doc_type' => UINDocumentType::class
        ];
    }

    public function getCustomerUinDocType(): ?UINDocumentType
    {
        return $this->customer_uin_doc_type;
    }

    public function setCustomerUinDocType(UINDocumentType $customer_uin_doc_type): void
    {
        $this->customer_uin_doc_type = $customer_uin_doc_type;
    }

    /**
     * @var UINDocumentType
     */
    private $customer_uin_doc_type = null;
}
