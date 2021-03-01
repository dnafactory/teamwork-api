<?php

namespace DNAFactory\Teamwork\Endpoints\Desk;

use DNAFactory\Teamwork\Endpoints\Router;
use DNAFactory\Teamwork\Exceptions\FakeEndpointException;
use DNAFactory\Teamwork\Models\CustomFieldOption;
use DNAFactory\Teamwork\RawEndpoints\Desk\CustomFields as RawCustomFields;
use DNAFactory\Teamwork\Support\RequestBuilder;

class CustomFieldOptions extends DeskEndpoint
{
    const REF_TYPE_NAME = 'customfieldoptions';

    protected bool $preloaded = false;

    public function __construct(RawCustomFields $rawEndpoint, Router $router)
    {
        parent::__construct($rawEndpoint, $router);
    }

    protected function makeOne(int $id): CustomFieldOption
    {
        return new CustomFieldOption($this, $id);
    }

    public function makeRequest(): RequestBuilder
    {
        throw new FakeEndpointException('This is a fake endpoint and should not be used');
    }

    protected function preload(int $id)
    {
        if ($this->preloaded) {
            return;
        }
        /** @var CustomFields $customfieldsApi */
        $customFieldsApi = $this->router->getEndpoint('customfields', static::REF_NAMESPACE);
        $customFieldsApi->makeRequest()->preload(['customfieldoptions'])->getArray();
        $this->preloaded = true;
    }
}