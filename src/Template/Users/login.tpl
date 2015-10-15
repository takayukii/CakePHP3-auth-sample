<div class="actions columns large-2 medium-3">
    <h3>{{__('Actions')}}</h3>
    <ul class="side-nav">
        <li>{{$this->Html->link(__('List Users'), ['action' => 'index'])}}</li>
    </ul>
</div>
<div class="samples form large-10 medium-9 columns">
    {{$this->Form->create()}}
    <fieldset>
        <legend>{{__('Login')}}</legend>
        {{$this->Form->input('name')}}
        {{$this->Form->input('password')}}
        {{$this->Form->input('remember_me', ['type' => 'checkbox'])}}
    </fieldset>
    {{$this->Form->button(__('Submit'))}}
    {{$this->Form->end()}}
</div>
