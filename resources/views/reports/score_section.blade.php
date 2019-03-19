<section class="wrapper score-categories">

    <div class="section-module grey-box">
        <h1>{{ $section['title'] }}</h1>
        <h2>{!! section_score_header($section_score, !empty($config['scoring']) ? $config['scoring'] : 'score') !!} <span class="not-bold">({{ $section_correct_count }}/{{ $section_question_count }} Correct)</span></h2>
    </div>
    
    @if(!$section_disable_section_categories_chart)            
        <div class="section-module">
            <h2>Score History</h2>
            @include('reports.score_section_historical_data')
        </div>
    @endif    
    
    <div class="score-categories-analysis">
        @include('reports.score_section_categories')
    </div>
</section>
