
@if(!empty($config['special_category_table']))

    @foreach($section_categories_score as $sectionCategoryId => $sectionCategory)

        @if(empty($config['special_category_table']) ||  in_array($sectionCategory['title'], $config['special_category_table']))

            <div class="section-module blue-box">

                <h4>{{ $sectionCategory['title'] }}</h4>
                <table class="score-sections">
                    <thead>
                        <tr>
                            <th></th>
                            @foreach($section_categories_terms_score[$sectionCategoryId] as $sectionCategoryTerm)
                                <th>{{ $sectionCategoryTerm['title'] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Correct</td>
                            @foreach($section_categories_terms_score[$sectionCategoryId] as $sectionCategoryTerm)
                                <td>{{ $sectionCategoryTerm['correct'] }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Incorrect</td>
                            @foreach($section_categories_terms_score[$sectionCategoryId] as $sectionCategoryTerm)
                                <td>{{ $sectionCategoryTerm['incorrect'] }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Omitted</td>
                            @foreach($section_categories_terms_score[$sectionCategoryId] as $sectionCategoryTerm)
                                <td>{{ $sectionCategoryTerm['omitted'] }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>% Correct</td>
                            @foreach($section_categories_terms_score[$sectionCategoryId] as $sectionCategoryTerm)
                                <td>
                                    {{ $sectionCategoryTerm['percentage_correct'] }}%
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>% Change from last test</td>
                            @foreach($section_categories_terms_score[$sectionCategoryId] as $sectionCategoryTerm)
                                <td class="change-percent-col {{ $sectionCategoryTerm['is_first_test'] ? '' : percentage_rate_class($sectionCategoryTerm['percentage_correct_gain'], 0) }}">
                                    @if($sectionCategoryTerm['is_first_test'])
                                        N/A
                                    @else
                                        {{ percentage_rate($sectionCategoryTerm['percentage_correct_gain'], true) }}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Points Lost</td>
                            @foreach($section_categories_terms_score[$sectionCategoryId] as $sectionCategoryTerm)
                                <td>{{ gain_if_correct($sectionCategoryTerm['section_score_gain_if_correct'], $sectionCategoryTerm['total'], $sectionCategoryTerm['correct'], $sectionCategory['metric_suffix']) }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>


        @endif

    @endforeach

@endif

@foreach($section_categories_score as $sectionCategoryId => $sectionCategory)

    @if(empty($config['special_category_table']) || !in_array($sectionCategory['title'], $config['special_category_table']))

        <div class="section-module">

            @if ($loop->first)
                <h2>Score Breakdown</h2>
            @endif

            <h4>{{ $sectionCategory['title'] }}</h4>
            <table class="score-subsections">
                <thead>
                    <tr>
                        <th></th>
                        <th>Correct</th>
                        <th>Incorrect</th>
                        <th>Omitted</th>
                        <th>% Correct</th>
                        <th>% Change from last test</th>
                        <th>Points Lost</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!$section_category_summary_ignore)
                        <tr class="summary">
                            <td>Summary</td>
                            <td>{{ $sectionCategory['correct'] }}</td>
                            <td>{{ $sectionCategory['incorrect'] }}</td>
                            <td>{{ $sectionCategory['omitted'] }}</td>
                            <td class="{{ percentage_rate_class($sectionCategory['percentage_correct']) }}">{{ $sectionCategory['percentage_correct'] }}%</td>
                            <td class="change-percent-col {{  $sectionCategory['is_first_test'] ? '' : percentage_rate_class($sectionCategory['percentage_correct_gain'], 0) }}">
                                @if($sectionCategory['is_first_test'])
                                    N/A
                                @else
                                    {{ percentage_rate($sectionCategory['percentage_correct_gain'], true) }}
                                @endif
                            </td>
                            <td>
                                {{ gain_if_correct($sectionCategory['section_score_gain_if_correct'], $sectionCategory['total'], $sectionCategory['correct'], $sectionCategory['metric_suffix']) }}
                            </td>
                        </tr>
                    @endif

                    @foreach($section_categories_terms_score[$sectionCategoryId] as $sectionCategoryTerm)
                        <tr>
                            <th>{{ $sectionCategoryTerm['title'] }}</th>
                            <td>{{ $sectionCategoryTerm['correct'] }}</td>
                            <td>{{ $sectionCategoryTerm['incorrect'] }}</td>
                            <td>{{ $sectionCategoryTerm['omitted'] }}</td>
                            <td class="{{ percentage_rate_class($sectionCategoryTerm['percentage_correct']) }}">{{ $sectionCategoryTerm['percentage_correct'] }}%</td>
                            <td class="change-percent-col {{ $sectionCategoryTerm['is_first_test'] ? '' : percentage_rate_class($sectionCategoryTerm['percentage_correct_gain'], 0) }}">
                                @if($sectionCategoryTerm['is_first_test'])
                                    N/A
                                @else
                                    {{ percentage_rate($sectionCategoryTerm['percentage_correct_gain'], true) }}
                                @endif
                            </td>
                            <td>
                                {{ gain_if_correct($sectionCategoryTerm['section_score_gain_if_correct'], $sectionCategoryTerm['total'], $sectionCategoryTerm['correct'], $sectionCategory['metric_suffix']) }}
                            </td>
                        </tr>
                        <tr class="score-results-missed">
                            <td colspan="7">
                                <table>
                                    @foreach($sectionCategoryTerm['answer_numbers'] as $answers_test_section_id => $test_section_answer_numbers)
                                        <tr>
                                            <td>
                                                @if(!empty($config['answers']['type']) && $config['answers']['type'] === 'combine')
                                                    Questions ({{ $sections[$answers_test_section_id]['short_title'] }}):
                                                @else
                                                    Questions:
                                                @endif
                                            </td>
                                            <td>
                                                @foreach($test_section_answer_numbers as $answer_number)
                                                    @if($answer_number['omitted'])
                                                        <span class="omitted">{{ $answer_number['number'] }}</span>
                                                    @elseif(!$answer_number['correct'])
                                                        <span class="incorrect">{{ $answer_number['number'] }}</span>
                                                    @else
                                                        <span>{{ $answer_number['number'] }}</span>
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>

    @endif
@endforeach
