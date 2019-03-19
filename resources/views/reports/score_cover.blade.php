

<section class="wrapper section-cover
                @if($is_first_test) cover-first-test @endif
                ">

    <h2 class="center">{{ $test_name }} Report for {{ $student_name }}</h2>


    <div class="section-module grey-box">
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
    </div>

    <div class="section-module section-module-scores">

        <table class="table-score">

            <thead>
                <tr>
                    <th colspan="2">Scores</th>
                    <th>Percentile</th>
                    @if(!empty($sections_stanine))
                        <th>Stanine</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @if(empty($config['disable_composite_summary']) || $config['disable_composite_summary'] !== true)
                    <tr class="total">
                        <td>Total:</td>
                        <td>{{ $composite_score }}</td>
                        <td>{{ str_ordinal($composite_percentile) }}</td>
                        @if(!empty($sections_stanine))
                            <td></td>
                        @endif
                        <td class="chart">
                            @include('reports.chart', [
                            'practice' => false,
                            'scale' => !empty($config['chart']['cover_scale']) ? $config['chart']['cover_scale'] : $config['chart']['scale'],
                            'value' => $composite_scoring_score
                            ])
                        </td>
                    </tr>
                @endif
                @foreach($sections as $sectionId => $section)
                    @if((empty($section['config']['show_summary']) || $section['config']['show_summary'] != 'exclude') && $section["inheritance"] === 'parent-section')
                        <tr>
                            <td>{{ $section['title'] }}</td>
                            <td>{{ $sections_score[$section['id']] }}</td>
                            <td>{{ str_ordinal($sections_percentile[$section['id']]) }}</td>
                            @if(!empty($sections_stanine))
                                <td>{{ $sections_stanine[$section['id']] }}</td>
                            @endif
                            <td class="chart">
                                @include('reports.chart', [
                                'practice' => false,
                                'scale' => !empty($section['config']['chart']['scale']) ? $section['config']['chart']['scale'] : $config['chart']['scale'],
                                'value' => $sections_scoring_score[$section['id']]
                                ])
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section-module">
        <h2>Algorithmic Analysis</h2>

        <div class="insight-main blue-box insight-issue-{{ $insights_main['issue'] }}">
            @include('reports/score_insight', [
            'insight' => $insights_main,
            'is_main' => true,
            'insight_number' => 1
            ])
        </div>

        @if($insights_secondary[0]['issue'] === 'pacing' && $insights_secondary[1]['issue'] === 'pacing')
            <div class="insights-secondary remove-questions">
        @else
                <div class="insights-secondary">
        @endif
        <div class="insight-secondary insight-issue-{{ $insights_secondary[0]['issue'] }}">
            @include('reports/score_insight', [
            'insight' => $insights_secondary[0],
            'is_main' => false,
            'insight_number' => 2
            ])
        </div>

        <div class="separator">
        </div>

        <div class="insight-secondary insight-issue-{{ $insights_secondary[1]['issue'] }}">
            @include('reports/score_insight', [
            'insight' => $insights_secondary[1],
            'is_main' => false,
            'insight_number' => 3
            ])
        </div>
                </div>
            </div>
</section>

<section class="wrapper section-score">

    <div class="section-module">

        <h2>Score History</h2>

        <table class="section-score-table">
            <thead>
                <tr>
                    <th></th>
                    <th>Form</th>
                    @if(empty($config['disable_composite_summary']) || $config['disable_composite_summary'] !== true)
                        <th class="score">
                            @if(!empty($config['section_score_history_label']))
                                {{ $config['section_score_history_label'] }}
                            @else
                                Score
                            @endif
                        </th>
                    @endif
                    @foreach($sections as $sectionId => $section)
                        @if($show_section_results[$sectionId])
                            <th class="table-cell-group">{{ strtoupper(letter_name($section['title'])) }}</th>
                        @endif
                    @endforeach
                    <th>
                        @if(!empty($config['section_score_table_chart_label']))
                            {{ $config['section_score_table_chart_label'] }}
                        @endif
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($composite_score_history as $result)
                    <tr class="{{ $result['current'] === true ? 'current-result-line' : '' }}">
                        <td>{{ $result['at'] }}</td>
                        <td>{{ $result['form'] }}</td>
                        @if(empty($config['disable_composite_summary']) || $config['disable_composite_summary'] !== true)
                            <td class="score">
                                {{ section_score_table($result['value'], $scoring) }}
                            </td>
                        @endif
                        @foreach($sections as $sectionId => $section)
                            @if($show_section_results[$sectionId])
                                <td class="table-cell-group">{{ $result['section_results'][$sectionId] }}</td>
                            @endif
                        @endforeach
                        <td class="chart">
                            @include('reports.chart', [
                            'practice' => $result['practice'],
                            'scale' => !empty($config['chart']['cover_scale']) ? $config['chart']['cover_scale'] : $config['chart']['cover_scale'],
                            'value' => $result['value']
                            ])
                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section-module">

        <h2>Test Analytics</h2>

        <table class="section-score-insight-table">
            <thead>
                <tr>
                    <th colspan="2">&nbsp;</th>
                    @foreach($sections as $sectionId => $section)
                        @if($show_section_results[$sectionId])
                            <th>{{ strtoupper($section['title']) }}</th>
                        @endif
                    @endforeach
                    @if(empty($config['disable_composite_summary']) || $config['disable_composite_summary'] !== true)
                        <th class="analytics-composite-column">
                            @if(!empty($config['section_score_history_label']))
                                {{ strtoupper($config['section_score_history_label']) }}
                            @else
                                COMPOSITE
                            @endif
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                <tr class="rotated-header">
                    <td rowspan="6"><span>History</span></td>
                </tr>
                <tr>
                    <td>This score</td>
                    @foreach($sections as $sectionId => $section)
                        @if($show_section_results[$sectionId])
                            <td>{{ section_score_table($sections_scores[$section['id']], $scoring) }}</td>
                        @endif
                    @endforeach
                    @if(empty($config['disable_composite_summary']) || $config['disable_composite_summary'] !== true)
                        <td class="analytics-composite-column">{{ section_score_table($composite_scoring_score, $scoring) }}</td>
                    @endif
                </tr>
                <tr>
                    <td>vs. last score</td>
                    @foreach($sections as $sectionId => $section)
                        @if($show_section_results[$sectionId])
                            <td class="{{ number_increment_class($sections_historical_score[$section['id']]['last_increment']) }}">
                                @if($sections_historical_score[$section['id']]['is_first_test'])
                                    N/A
                                @else
                                    {{ number_increment_sign($sections_historical_score[$section['id']]['last_increment']) }}{{ $sections_historical_score[$section['id']]['last_increment'] }}
                                @endif
                            </td>
                        @endif
                    @endforeach
                    @if(empty($config['disable_composite_summary']) || $config['disable_composite_summary'] !== true)
                        <td class="analytics-composite-column {{ number_increment_class($historical_composite_score['last_increment']) }}">
                            @if($historical_composite_score['is_first_test'])
                                N/A
                            @else
                                {{ number_increment_sign($historical_composite_score['last_increment']) }}{{ $historical_composite_score['last_increment'] }}
                            @endif
                        </td>
                    @endif
                </tr>
                <tr>
                    <td>vs. first score</td>
                    @foreach($sections as $sectionId => $section)
                        @if($show_section_results[$sectionId])
                            <td class="{{ number_increment_class($sections_historical_score[$section['id']]['first_increment']) }}">
                                @if($sections_historical_score[$section['id']]['is_first_test'])
                                    N/A
                                @else

                                    {{ number_increment_sign($sections_historical_score[$section['id']]['first_increment'])}}{{ $sections_historical_score[$section['id']]['first_increment'] }}
                                @endif
                            </td>
                        @endif
                    @endforeach
                    @if(empty($config['disable_composite_summary']) || $config['disable_composite_summary'] !== true)
                        <td class="analytics-composite-column {{ number_increment_class($historical_composite_score['first_increment']) }}">
                            @if($historical_composite_score['is_first_test'])
                                N/A
                            @else
                                {{ number_increment_sign($historical_composite_score['first_increment']) }}{{ $historical_composite_score['first_increment'] }}
                            @endif
                        </td>
                    @endif
                </tr>
                <tr>
                    <td>Personal best</td>
                    @foreach($sections as $sectionId => $section)
                        @if($show_section_results[$sectionId])
                            <td>{{ section_score_table($sections_historical_score[$section['id']]['best_score'], $scoring) }}</td>
                        @endif
                    @endforeach
                    @if(empty($config['disable_composite_summary']) || $config['disable_composite_summary'] !== true)
                        <td class="analytics-composite-column">{{ section_score_table($historical_composite_score['best_score'], $scoring) }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Overall Progress</td>
                    @foreach($sections as $sectionId => $section)
                        @if($show_section_results[$sectionId])
                            <td class="{{ number_increment_class($sections_historical_score[$section['id']]['best_first_increment']) }}">
                                @if($sections_historical_score[$section['id']]['is_first_test'])
                                    N/A
                                @else
                                    {{ number_increment_sign($sections_historical_score[$section['id']]['best_first_increment'])}}{{ $sections_historical_score[$section['id']]['best_first_increment'] }}
                                @endif
                            </td>
                        @endif
                    @endforeach
                    @if(empty($config['disable_composite_summary']) || $config['disable_composite_summary'] !== true)
                        <td class="analytics-composite-column {{ number_increment_class($historical_composite_score['best_first_increment']) }}">
                            @if($historical_composite_score['is_first_test'])
                                N/A
                            @else
                                {{ number_increment_sign($historical_composite_score['best_first_increment']) }}{{ $historical_composite_score['best_first_increment'] }}
                            @endif
                        </td>
                    @endif
                </tr>
                <tr class="inside-margin">
                    <td colspan="999999"></td>
                </tr>
                <tr class="rotated-header">
                    <td rowspan="6"><span>Insights</span></td>
                </tr>
                <tr class="primary-issue">
                    <td>Primary Issue</td>
                    @foreach($sections as $sectionId => $section)
                        @if($show_section_results[$sectionId])
                            <td>
                                @if($insights_sections[$sectionId]['issue'] !== 'content')
                                    {{ ucfirst($insights_sections[$sectionId]['issue']) }}
                                @else
                                    {{ $insights_sections[$sectionId]['content_name'] }}
                                @endif
                            </td>
                        @endif
                    @endforeach
                    @if(empty($config['disable_composite_summary']) || $config['disable_composite_summary'] !== true)
                        <td class="analytics-composite-column">
                            @if($insights_main['issue'] !== 'content')
                                {{ ucfirst($insights_main['issue']) }}
                            @else
                                {{ $insights_main['content_name'] }}
                            @endif

                        </td>
                    @endif
                </tr>
                <tr>
                    <td>Points lost</td>
                    @foreach($sections as $sectionId => $section)
                        @if($show_section_results[$sectionId])
                            <td>
                                {{ $insights_sections[$sectionId]['points_lost'] }}
                            </td>
                        @endif
                    @endforeach
                    @if(empty($config['disable_composite_summary']) || $config['disable_composite_summary'] !== true)
                        <td class="analytics-composite-column">
                            {{ $insights_main['composite_score_if_mastered'] - $composite_scoring_score  }}
                        </td>
                    @endif
                </tr>
                <tr>
                    <td>Score if mastered</td>
                    @foreach($sections as $sectionId => $section)
                        @if($show_section_results[$sectionId])
                            <td>
                                {{ $insights_sections[$sectionId]['score_if_mastered'] }}
                            </td>
                        @endif
                    @endforeach
                    @if(empty($config['disable_composite_summary']) || $config['disable_composite_summary'] !== true)
                        <td class="analytics-composite-column">
                            {{ $insights_main['composite_score_if_mastered'] }}
                        </td>
                    @endif
                </tr>
                <tr>
                    <td># of errors</td>
                    @foreach($sections as $sectionId => $section)
                        @if($show_section_results[$sectionId])
                            <td>
                                {{ count($insights_sections[$sectionId]['missed']) }}
                            </td>
                        @endif
                    @endforeach
                    @if(empty($config['disable_composite_summary']) || $config['disable_composite_summary'] !== true)
                        <td class="analytics-composite-column">
                            {{ count($insights_main['missed']) }}
                        </td>
                    @endif
                </tr>
                <tr>
                    <td># of omits</td>
                    @foreach($sections as $sectionId => $section)
                        @if($show_section_results[$sectionId])
                            <td>
                                {{ count($insights_sections[$sectionId]['omitted']) }}
                            </td>
                        @endif
                    @endforeach
                    @if(empty($config['disable_composite_summary']) || $config['disable_composite_summary'] !== true)
                        <td class="analytics-composite-column">
                            {{ count($insights_main['omitted']) }}
                        </td>
                    @endif
                </tr>

            </tbody>
        </table>
    </div>
</section>
