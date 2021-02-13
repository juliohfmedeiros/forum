<?php

namespace spec\App\Domain\AnswerManagement\Answer;

use App\Domain\Common\RootAggregatorId;
use App\Domain\AnswerManagement\Answer\AnswerId;
use PhpSpec\ObjectBehavior;

class AnswerIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AnswerId::class);
    }

    function its_a_root_aggregate_identifier()
    {
        $this->shouldBeAnInstanceOf(RootAggregatorId::class);
    }
}
