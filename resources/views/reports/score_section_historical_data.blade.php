<table class="section-score-table">
    <thead>
        <tr>
            <th></th>
            <th>Form</th>
            <th>
                @if(!empty($config['section_score_history_label']))
                    {{ $config['section_score_history_label'] }}
                @else
                    Score
                @endif
            </th>
            <th>
                <span class="header-label__bubble header-label__bubble--mock-test"></span>
                <span class="header-label__text--trailing-space">Mock test</span>
                <span class="header-label__bubble header-label__bubble--homework"></span>
                <span class="header-label__text">Homework</span>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($section_composite_score_history as $result)
            <tr class="{{ $result['current'] === true ? 'current-result-line' : '' }}">
                <td>{{ $result['at'] }}</td>
                <td>{{ $result['form'] }}</td>
                <td>
                    {{ section_score_table($result['value'], $scoring) }}
                </td>
                <td class="chart">
                    @include('reports.chart', [
                    'practice' => $result['practice'],
                    'scale' => $config['chart']['scale'],
                    'value' => $result['value']
                    ])
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
