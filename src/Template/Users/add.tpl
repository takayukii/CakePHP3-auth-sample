<div class="actions columns large-2 medium-3">
    <h3>{{__('Actions')}}</h3>
    <ul class="side-nav">
        <li>{{$this->Html->link(__('List Users'), ['action' => 'index'])}}</li>
    </ul>
</div>
<div class="samples form large-10 medium-9 columns">
    {{$this->Form->create($user)}}
    <fieldset>
        <legend>{{__('Add User')}}</legend>
        {{$this->Form->input('name')}}
        {{$this->Form->input('password')}}
    </fieldset>
    {{$this->Form->button(__('Submit'))}}
    {{$this->Form->end()}}
</div>
