<?php

const QUESTION_TYPE_MULTIPLE_CHOICE = 1;
const QUESTION_TYPE_ONE_OF_VALUES   = 2;

if (! function_exists('str_ordinal')) {
    /**
     * Append an ordinal indicator to a numeric value.
     *
     * @param  string|int  $value
     * @param  bool  $superscript
     * @return string
     */
    function str_ordinal($value, $superscript = false)
    {
        $number = abs($value);

        $indicators = ['th','st','nd','rd','th','th','th','th','th','th'];

        $suffix = $superscript ? '<sup>' . $indicators[$number % 10] . '</sup>' : $indicators[$number % 10];
        if ($number % 100 >= 11 && $number % 100 <= 13) {
            $suffix = $superscript ? '<sup>th</sup>' : 'th';
        }

        return number_format($number) . $suffix;
    }
}

if (! function_exists('number_increment_sign')) {
    /**
     * Append an ordinal indicator to a numeric value.
     *
     * @param  string|int  $value
     * @param  bool  $superscript
     * @return string
     */
    function number_increment_sign($value)
    {
        if($value >= 0) {
            return '+';
        } else {
            return '';
        }
    }
}


if (! function_exists('percentage_rate_class')) {
    /**
     * Append a class name.
     *
     * @param  string|int  $value
     * @param  bool  $superscript
     * @return string
     */
    function percentage_rate_class($value, $base = 50)
    {
        if(!is_numeric($value)) {
            $value = 0;
        }

        $percentage = (float)$value;

        if($percentage == 100) {
            return 'excelent';
        }

        if($percentage == 0) {
            return 'neutral';
        }

        if($percentage < $base) {
            return 'poor';
        }

        return 'ok';
    }
}

if (! function_exists('percentage_rate')) {
    /**
     * Append a class name.
     *
     * @param  string|int  $value
     * @param  bool  $superscript
     * @return string
     */
    function percentage_rate($value, $append_plus = false)
    {
        $percentage = (float)$value;

        if($percentage > 0) {
            return ($append_plus ? "+" : "").$percentage."%";
        } else {
            return $percentage."%";
        }
    }
}

if (! function_exists('number_increment_class')) {
    /**
     * Append a class name.
     *
     * @param  string|int  $value
     * @param  bool  $superscript
     * @return string
     */
    function number_increment_class($value)
    {
        return $value > 0 ? 'positive' : ($value < 0 ? 'negative' : 'unchanged');
    }
}

if (! function_exists('question_type_class')) {
    /**
     * Append a class name.
     *
     * @param  string|int  $value
     * @param  bool  $superscript
     * @return string
     */
    function question_type_class($type)
    {
        switch($type) {
        case QUESTION_TYPE_MULTIPLE_CHOICE :
            return ''; // Default, no class
        case QUESTION_TYPE_ONE_OF_VALUES :
            return 'type-ofc';
        }

        return '';
    }
}

if (! function_exists('section_score_header')) {
    /**
     * Append a class name.
     *
     * @param  string|int  $value
     * @param  bool  $superscript
     * @return string
     */
    function section_score_header($section_score, $scoring = 'score')
    {
        if($scoring == 'percentile') {
            return 'Your Score: '.str_ordinal($section_score);
        } else if($scoring == 'stanine') {
            return 'Your Stanine: '.$section_score;
        }

        return 'Your Score: '.$section_score;
    }
}

if (! function_exists('section_score_composite_header')) {
    /**
     * Append a class name.
     *
     * @param  string|int  $value
     * @param  bool  $superscript
     * @return string
     */
    function section_score_composite_header($score, $scoring = 'score')
    {
        if($scoring == 'percentile') {
            return 'Your Percentile: '.str_ordinal($score);
        }

        return 'Your Score: '.$score;
    }
}

if (! function_exists('section_score_table')) {
    /**
     * Append a class name.
     *
     * @param  string|int  $value
     * @param  bool  $superscript
     * @return string
     */
    function section_score_table($score, $scoring = 'score')
    {
        if($scoring == 'percentile') {
            return str_ordinal($score);
        }

        return $score;
    }
}

if (! function_exists('gain_if_correct')) {
    /**
     * Append a class name.
     *
     * @param  string|int  $value
     * @param  bool  $superscript
     * @return string
     */
    function gain_if_correct($score_increment, $total, $correct, $suffix)
    {
        if($total == $correct) {
            return 'N/A';
        }

        return $score_increment. " ".$suffix;
    }
}

if (! function_exists('answer_status_class')) {
    /**
     * Append a class name.
     *
     * @param  string|int  $value
     * @param  bool  $superscript
     * @return string
     */
    function answer_status_class($answer)
    {
        if($answer['is_correct']) {
            return 'correct';
        } else if($answer['is_unanswered']) {
            return 'unanswered';
        } else {
            return 'incorrect';
        }
    }
}

if (! function_exists('answer_status_tags_class')) {
    /**
     * Append a class name.
     *
     * @param  string|int  $value
     * @param  bool  $superscript
     * @return string
     */
    function answer_status_tags_class($answer)
    {
        if(($answer['has_tags'])) {
            return 'warning';
        }

        return '';
    }
}

if (! function_exists('letter_name')) {

    function letter_name($name) {
        $words = preg_split("/\s+/", str_replace(['(', ')'], [' ',' '], $name));
        $letterName = "";
        foreach ($words as $w) {
            $letterName .= isset($w[0]) ? $w[0] : '';
        }

        return $letterName;
    }
}
