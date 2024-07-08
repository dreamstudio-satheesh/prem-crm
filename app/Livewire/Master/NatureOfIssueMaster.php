<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\NatureOfIssue;

class NatureOfIssueMaster extends Component
{
    use WithPagination;

    public $issue_id, $name, $description;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
    ];

    public function render()
    {
        $issues = NatureOfIssue::where('name', 'like', '%' . $this->search . '%')
                               ->orderBy('id', 'desc')
                               ->paginate(10);

        return view('livewire.master.nature-of-issue-master', [
            'issues' => $issues,
        ]);
    }

    public function resetInputFields()
    {
        $this->issue_id = null;
        $this->name = '';
        $this->description = '';
    }

    public function create()
    {
        $this->resetInputFields();  // Reset all input fields
        $this->resetErrorBag();     // Optionally, clear any validation errors
        $this->issue_id = null;     // Ensure no id is set when creating new entry
    }

    public function store()
    {
        $this->validate();

        NatureOfIssue::updateOrCreate(['id' => $this->issue_id], [
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->resetInputFields();
        session()->flash('success', 'Nature of Issue ' . ($this->issue_id ? 'Updated' : 'Created') . ' Successfully.');
    }

    public function edit($id)
    {
        $issue = NatureOfIssue::findOrFail($id);
        $this->issue_id = $issue->id;
        $this->name = $issue->name;
        $this->description = $issue->description;
    }

    public function delete($id)
    {
        $issue = NatureOfIssue::find($id);
        if ($issue) {
            $issue->delete();
            session()->flash('success', 'Nature of Issue Deleted Successfully.');
        } else {
            session()->flash('error', 'Nature of Issue Not Found.');
        }
    }
}
