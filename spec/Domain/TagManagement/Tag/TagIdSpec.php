<?php

namespace spec\App\Domain\TagManagement\Tag;

use App\Domain\Common\RootAggregatorId;
use App\Domain\TagManagement\Tag\TagId;
use PhpSpec\ObjectBehavior;

class TagIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TagId::class);
    }

    function its_a_root_aggregate_identifier()
    {
        $this->shouldBeAnInstanceOf(RootAggregatorId::class);
    }
}
