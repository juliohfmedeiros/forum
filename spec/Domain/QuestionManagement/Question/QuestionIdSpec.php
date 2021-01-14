<?php

namespace spec\App\Domain\QuestionManagement\Question;

use App\Domain\Common\RootAggregatorId;
use App\Domain\QuestionManagement\Question\QuestionId;
use PhpSpec\ObjectBehavior;

class QuestionIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(QuestionId::class);
    }

    function its_a_root_aggregate_identifier()
    {
        $this->shouldBeAnInstanceOf(RootAggregatorId::class);
    }
}
