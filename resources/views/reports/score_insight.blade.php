<h3>ISSUE {{ $insight_number }}:
    @if($insight['issue'] !== 'content')
        {{ ucfirst($insight['issue']) }} in
    @endif
    {{ ucfirst($insight['target_name']) }}</h3>
<p>
    <b>
        @if(!empty($config['insights_scoring']) && $config['insights_scoring'] === 'percentile')
            Percentile points lost:
        @else
            Points lost:             
        @endif
        <span class="lost">-{{ $insight['points_lost'] }}</span>
        | % incorrect:&nbsp;
        <span class="lost">
            @if(is_numeric( $insight['percent_incorrect'] ) && floor( $insight['percent_incorrect'] ) == $insight['percent_incorrect'] ) 
            {{ $insight['percent_incorrect'] }}%
        @else        
            {{ number_format($insight['percent_incorrect'], 2) }}%
        @endif
        </span>
    </b><br/>
    <b>Section score if mastered: <span class="gain">{{ $insight['score_if_mastered'] }}</span></b><br/>

    @if($insight['composite_score_if_mastered'] > 0)        
        <b>Composite score if mastered: <span class="gain">{{ $insight['composite_score_if_mastered'] }}</span></b>
    @endif
</p>

@if($is_main)

    <p>
        <b>The issue:</b> @lang('reports.'.$insight['issue'].'_issue', [
        'name' => $insight['target_name']
        ])
    </p>
    <p>
        <b>What to work on:</b> @lang('reports.'.$insight['issue'].'_work', [
        'name' => $insight['target_name']
        ])
    </p>
@endif

<p class="answers-drilldown">
    <b>
        Missed:
        <span class="lost">
            @foreach($insight['missed'] as $missed)
                {{ $missed }}
            @endforeach
        </span>
    </b><br/>
    <b>
        Omitted:
        <span>
            @foreach($insight['omitted'] as $omitted)
                {{ $omitted }}
            @endforeach                        
        </span>
    </b>
</p>
