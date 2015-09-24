<div class="actions columns large-2 medium-3">
    <h3>{{__('Actions')}}</h3>
    <ul class="side-nav">
        <li>
            {{$this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $sample->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $sample->id)]
            )}}
        </li>
        <li>{{$this->Html->link(__('List Samples'), ['action' => 'index'])}}</li>
    </ul>
</div>
<div class="samples form large-10 medium-9 columns">
    {{$this->Form->create($sample)}}
    <fieldset>
        <legend>{{__('Edit Sample')}}</legend>
        {{$this->Form->input('sample_name')}}
        {{$this->Form->input('sample_profile')}}
    </fieldset>
    {{$this->Form->button(__('Submit'))}}
    {{$this->Form->end()}}
</div>
