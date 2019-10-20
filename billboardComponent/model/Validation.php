<?php

namespace Billboard;

class Validation
{

    private static $emptyField = 0;

    public function postValidation(Post $post)
    {
        $this->isFieldFilled($post->getTitle());
        $this->isFieldFilled($post->getText());
        $this->isNoHTMLTags($post->getTitle());
        $this->isNoHTMLTags($post->getText());
    }

    public function commentValidation(PostComment $comment)
    {
        $this->isFieldFilled($comment->getText());
        $this->isNoHTMLTags($comment->getText());
    }

    private function isFieldFilled($text)
    {
        if (strlen($text) === self::$emptyField) {
            throw new \EmptyField('All empty field in submit');
        }
    }

    private function isNoHTMLTags($text)
    {
        $textWithoutTags = strip_tags($text);
        if ($textWithoutTags != $text) {
            throw new \HTMLTagsInText('Text: "' . $text . '" contains script tags');
        }
    }
}
