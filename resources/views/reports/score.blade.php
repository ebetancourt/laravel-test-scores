<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <!-- <link rel="shortcut icon" href="" type="image/x-icon"> -->
        <title>Forum - Score Results </title>

        <link rel="stylesheet" data-include-header-footer="" type="text/css" href="{{ URL::asset('/css/report.css') }}">        
        
        <script src="{{ URL::to('/js/reporting_charts.js') }}" charset="utf-8"></script>        
    </head>
    <body class="{{ $report_name }}">
        <header>
            <p>
                <img src="{{ URL::asset('/images/forum-logo.svg') }}" alt="" class="forum-logo">
            </p><p>www.forumeducation.nyc<br>forum@forumeducation.nyc</p>
        </header>

        @includeWhen($mock_test, 'reports.score_cover')

        @if($mock_test) 
            @include('reports.score_answers')
        @endif
        
        @foreach($sections as $section)

            @if($show_section_results[$section['id']])
                
                @include('reports.score_section', [
                'section_question_count'          => $sections[$section['id']]['question_count'],
                'section_correct_count'           => $sections_answers_aggregation[$section['id']]['correct'],
                'section_score'                   => $sections_scores[$section['id']],
                'section_categories_score'        => $sections_categories_score[$section['id']],
                'section_categories_terms_score'  => $sections_categories_terms_score[$section['id']],
                'section_category_summary_ignore' => $sections_category_summary_ignore[$section['id']],
                'section_composite_score_history' => $sections_composite_score_history[$section['id']],
                'section_disable_section_categories_chart' => $disable_sections_categories_chart[$section['id']],
                'config' => array_merge([ ], $config, $section['config'])
                ])

            @endif

        @endforeach

        @if(!$mock_test) 
            @include('reports.score_answers')
        @endif
        
        <footer>
            <table>
                <tr>
                    <td>{{ $student_l_name_first }}</td>
                    <td>{{ $test_form_name }} - {{ $report_at }}</td>
                    <td>
                        <span class="page">1</span>/<span class="topage">1</span>
                    </td>                    
                </tr> 
            </table>
        </footer>
    </body>
</html>
