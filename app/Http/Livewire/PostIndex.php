<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostIndex extends Component
{
    use WithFileUploads;
    public $showingPostModal, $isEditMode = false;
    public $title, $newImage, $content, $oldImage, $post;

    public function render()
    {
        return view('livewire.post-index', [
            'posts' => Post::latest()->get()
        ]);
    }

    public function showPostModal()
    {
        $this->reset();
        $this->showingPostModal = true;
    }

    public function showEditPostModal($id)
    {
        $this->post = Post::findOr($id);
        $this->title = $this->post->title;
        $this->content = $this->post->content;
        $this->oldImage = $this->post->image;

        $this->isEditMode = true;
        $this->showingPostModal = true;
    }

    public function storePost(Request $request)
    {
        $this->validate([
            'newImage' => 'image|max:2026',
            'title' => 'required',
            'content' => 'required'
        ]);

        $image = $this->newImage->store('public/postImages');

        Post::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'image' => $image,
            'content' => $this->content
        ]);
        $this->reset();
    }

    public function updatePost()
    {
        $this->validate([
            
            'title' => 'required',
            'content' => 'required'
        ]);

        $image = $this->post->image;
        if ($this->newImage) {

            $post = Post::findOr($this->post->id);
            Storage::delete($post->image);
            
            $image = $this->newImage->store('public/postImages');
        }

        $this->post->update([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'content' => $this->content,
            'image' => $image
        ]);

        $this->reset();
    }

    public function deletePost($id)
    {
       $post = Post::findOr($id);
       Storage::delete($post->image);
       $post->delete();
       $this->reset();
    }
}
