<?php

namespace spec\App\Domain\AnswerManagement\Specification;

use App\Domain\AnswerManagement\Answer;
use App\Domain\AnswerManagement\AnswerSpecification;
use App\Domain\AnswerManagement\Specification\AcceptAnswer;
use PhpSpec\ObjectBehavior;

class AcceptAnswerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AcceptAnswer::class);
    }

    function its_a_answer_specification()
    {
        $this->shouldBeAnInstanceOf(AnswerSpecification::class);
    }

    function its_true_when_answer_has_open_flag_to_true(Answer $answer)
    {
        $answer->accepted()->willReturn(true);
        $this->isSatisfiedBy($answer)->shouldBe(true);
    }

    function its_false_when_answer_has_open_flag_to_false(Answer $answer)
    {
        $answer->accepted()->willReturn(false);
        $this->isSatisfiedBy($answer)->shouldBe(false);
    }

    function it_can_be_created_statically()
    {
        $this->beConstructedThrough('create');
        $this->shouldHaveType(AcceptAnswer::class);
    }
}
