<div class="actions columns large-2 medium-3">
    <h3>{{__('Actions')}}</h3>
    <ul class="side-nav">
        <li>{{$this->Html->link(__('Edit Sample'), ['action' => 'edit', $sample->id])}} </li>
        <li>{{$this->Form->postLink(__('Delete Sample'), ['action' => 'delete', $sample->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sample->id)])}} </li>
        <li>{{$this->Html->link(__('List Samples'), ['action' => 'index'])}} </li>
        <li>{{$this->Html->link(__('New Sample'), ['action' => 'add'])}} </li>
    </ul>
</div>
<div class="samples view large-10 medium-9 columns">
    <h2>{{h($sample->id)}}</h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader">{{__('Sample Name')}}</h6>
            <p>{{h($sample->sample_name)}}</p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader">{{__('Id')}}</h6>
            <p>{{$this->Number->format($sample->id)}}</p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader">{{__('Created')}}</h6>
            <p>{{h($sample->created)}}</p>
            <h6 class="subheader">{{__('Modified')}}</h6>
            <p>{{h($sample->modified)}}</p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader">{{__('Sample Profile')}}</h6>
            {{$this->Text->autoParagraph(h($sample->sample_profile))}}
        </div>
    </div>
</div>
