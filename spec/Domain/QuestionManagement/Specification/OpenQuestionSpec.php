<?php

namespace spec\App\Domain\QuestionManagement\Specification;

use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\QuestionSpecification;
use App\Domain\QuestionManagement\Specification\OpenQuestion;
use PhpSpec\ObjectBehavior;

class OpenQuestionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(OpenQuestion::class);
    }

    function its_a_question_specification()
    {
        $this->shouldBeAnInstanceOf(QuestionSpecification::class);
    }

    function its_true_when_question_has_open_flag_to_true(Question $question)
    {
        $question->isOpen()->willReturn(true);
        $this->isSatisfiedBy($question)->shouldBe(true);
    }

    function its_false_when_question_has_open_flag_to_false(Question $question)
    {
        $question->isOpen()->willReturn(false);
        $this->isSatisfiedBy($question)->shouldBe(false);
    }

    function it_can_be_created_statically()
    {
        $this->beConstructedThrough('create');
        $this->shouldHaveType(OpenQuestion::class);
    }
}
