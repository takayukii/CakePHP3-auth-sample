<div class="actions columns large-2 medium-3">
    <h3>{{__('Actions')}}</h3>
    <ul class="side-nav">
        <li>{{$this->Html->link(__('New Sample'), ['action' => 'add'])}}</li>
    </ul>
</div>
<div class="samples index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th>{{$this->Paginator->sort('id')}}</th>
            <th>{{$this->Paginator->sort('sample_name')}}</th>
            <th>{{$this->Paginator->sort('created')}}</th>
            <th>{{$this->Paginator->sort('modified')}}</th>
            <th class="actions">{{__('Actions')}}</th>
        </tr>
    </thead>
    <tbody>
    {{foreach from=$samples item=sample}}
        <tr>
            <td>{{$this->Number->format($sample->id)}}</td>
            <td>{{h($sample->sample_name)}}</td>
            <td>{{h($sample->created)}}</td>
            <td>{{h($sample->modified)}}</td>
            <td class="actions">
                {{$this->Html->link(__('View'), ['action' => 'view', $sample->id])}}
                {{$this->Html->link(__('Edit'), ['action' => 'edit', $sample->id])}}
                {{$this->Form->postLink(__('Delete'), ['action' => 'delete', $sample->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sample->id)])}}
            </td>
        </tr>

    {{/foreach}}
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            {{$this->Paginator->prev('< '|cat:__('previous'))}}
            {{$this->Paginator->numbers()}}
            {{$this->Paginator->next(__('next')|cat:' >')}}
        </ul>
        <p>{{$this->Paginator->counter()}}</p>
    </div>
</div>
