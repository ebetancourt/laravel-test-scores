<section class="wrapper score-answers">

    <div class="score-answers-inner">

        <div class="score-answers-column-wrapper clearfix">
            @foreach($sections as $sectionId => $section)
                @if(!empty($sections_answers[$sectionId]))
                    <div class="score-answers-column">
                        <h4>{{ $section['title'] }}</h4>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="score-answers-column-wrapper clearfix">
            @foreach($sections as $sectionId => $section) 
                
                @if(!empty($sections_answers[$sectionId]))
                    <div class="score-answers-column">

                        <div class="score-answers-column-inner">
                            
                            <table class="small-table answers-table-columns-{{ 4 + count($sections_answers[$sectionId]['columns']) }}">
                                <thead>
                                    <tr>
                                        <th class="rotated-highlight"><span>Question #</span></th>
                                        @foreach($sections_answers[$sectionId]['columns'] as $answerColumn)
                                            <th class="rotated-highlight"><span>{{ $answerColumn }}</span></th>
                                        @endforeach
                                        <th class="rotated-highlight"><span>Your Answer</span></th>
                                        <th class="rotated-highlight"><span>Correct</span></th>
                                        <th class="rotated-highlight"><span>Tags</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php ($flip = -1)
                                    @php ($lastColumnValue = '')
                                    @foreach($sections_answers[$sectionId]['answers'] as $answer)
                                        <tr class="{{ question_type_class($answer['question_type']) }}">
                                            <td>{{ $answer['question_number'] }}</td>
                                             
                                            @foreach($sections_answers[$sectionId]['columns'] as $answerColumn)

                                                @if(!empty($answer[$answerColumn]) && $lastColumnValue !== $answer[$answerColumn]) 
                                                    @php ($flip++)
                                                    @php ($lastColumnValue = $answer[$answerColumn])
                                                @endif
                                                    
                                                <td class="@if($flip % 2 === 0) odd @endif">{{ !empty($answer[$answerColumn]) ?  $answer[$answerColumn] : 'N/A' }}</td>
                                            @endforeach                                            
                                                           <td class="{{ answer_status_class($answer) }}">{{ !empty($answer['answer_letter']) ? strtoupper($answer['answer_letter']) : 'O' }}</td>
                                            <td>{{ strtoupper($answer['right_answer_letter']) }}</td>
                                            <td
                                                @if(!empty($answer['tags']))
                                                class="have-tags"
                                                @endif
                                            >{{ implode('/',$answer['tags']) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody> 
                            </table>

                            @if(!empty($sections_answers[$sectionId]['column_legends']))
                                <ul class="answer-column-legends">
                                    @foreach($sections_answers[$sectionId]['column_legends'] as $shortName => $legend)
                                        <li>{{ $shortName }} - {{ $legend }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
