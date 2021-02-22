<?php

namespace DNAFactory\Teamwork\Models\Projects;

use DNAFactory\Teamwork\Models\BaseModel;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $description
 * @property-read string $type
 * @property-read string $link
 * @property-read Tag[] $tags
 * @property-read Company $company
 */
class Project extends BaseModel
{
    protected function getTags(): array
    {
        $references = $this->getRawAttribute('tags', []);
        return $this->retriveManyReferences($references);
    }

    protected function getCompany(): Company
    {
        $reference = $this->getRawAttribute('company');
        return $this->endpoint->retriveReference($reference);
    }

    protected function getLink()
    {
        return sprintf('%s/#/projects/%d', $this->endpoint->getBaseUrl(), $this->id);
    }

    public function hasEveryTag(array $tags)
    {
        $ownTags = $this->tags;
        foreach ($tags as $tag) {
            if (!in_array($tag, $ownTags)) {
                return false;
            }
        }
        return true;
    }

    public function hasAnyTag(array $tags)
    {
        $ownTags = $this->tags;
        foreach ($tags as $tag) {
            if (in_array($tag, $ownTags)) {
                return true;
            }
        }
        return false;
    }
}
