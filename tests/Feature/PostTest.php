<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\BlogPost;
use App\Models\Comment;

class PostTest extends TestCase
{
    use RefreshDatabase; 

    public function createDummyPost() 
    {
        return  BlogPost::factory()->make();
    }
    
    public function test_noBlogpostsWhenNoDatainDB()
    {
        $response = $this->get('/posts');

        $response->assertSeeText("No post found!");
    }
    public function test_seeOneBlogPostWhenThereIsOnlyOneWithNoComments()
    {
        //Arrange
        $post = $this->createDummyPost();

        $post->save();

        //Act
        $response = $this->get('/posts');
        //Assert
        $response->assertSeeText($post->title);
        $response->assertSeeText("No comments yet.");
        $this->assertDatabaseHas('blog_posts', [ 'title' => $post->title]);
    }

    public function test_seeOneBlogPostWhenThereIsOnlyOneWithComments()
    {
        //Arrange
        $post = $this->createDummyPost();

        $post->save();
        $comment = Comment::factory()->state(['blog_post_id' => $post->id])->count(4)->create();

        //Act
        $response = $this->get('/posts');
        //Assert
        $response->assertSeeText($post->title);
        $response->assertSeeText("Number of comments 4");
        $this->assertDatabaseHas('blog_posts', [ 'title' => $post->title]);
    }

    public function test_storeValidPost()
    {
        //Arrange
        $post = BlogPost::factory()->make();
        
        $this->post('/posts', ['title' => $post->title, 'content' => $post->content])->assertStatus(302)->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blogpost created successfully');
    }

    public function test_storeFailPostTitleTooShortBags()
    {
        //Arrange
        $post = BlogPost::factory()->make();
        
        $this->post('/posts', ['title' => 'x', 'content' => $post->content])->assertStatus(302)->assertSessionHas('errors');
        $messages = session('errors');
       $e =  $messages->getBag('default')->getMessages();
       $this->assertArrayHasKey('title', $e);
       $this->assertEquals($e['title'][0], 'The title must be at least 5 characters.');
    }

    public function test_storeFailPostContentTooShortBags()
    {
        //Arrange
        $post = BlogPost::factory()->make();
        
        $this->post('/posts', ['title' => $post->title, 'content' => 'x'])->assertStatus(302)->assertSessionHas('errors');
        $messages = session('errors');
       $e =  $messages->getBag('default')->getMessages();
       $this->assertArrayHasKey('content', $e);
       $this->assertEquals($e['content'][0], 'The content must be at least 10 characters.');
    }

    public function test_storeFailPostFieldsTooShortBags()
    {
        //Arrange
        $post = BlogPost::factory()->make();
        
        $this->post('/posts', ['title' => 'x', 'content' => 'x'])->assertStatus(302)->assertSessionHas('errors');
        $messages = session('errors');
       $e =  $messages->getBag('default')->getMessages();
       $this->assertArrayHasKey('title', $e);
       $this->assertArrayHasKey('content', $e);
       $this->assertEquals($e['content'][0], 'The content must be at least 10 characters.');
       $this->assertEquals($e['title'][0], 'The title must be at least 5 characters.');
    }
    public function test_storeFailPostTitleTooShort()
    {
        //Arrange
        $post = BlogPost::factory()->make();
        
        $this->post('/posts', ['title' => 'x', 'content' => $post->content])->assertSessionHasErrors(['title']);
    }

    public function test_storeFailPostContentTooShort()
    {
        //Arrange
        $post = BlogPost::factory()->make();
        
        $this->post('/posts', ['title' => $post->title, 'content' => 'x'])->assertSessionHasErrors(['content']);
    }
    
    public function test_seeOneBlogPostEditFunction()
    {
        // $this->withoutExceptionHandling();
        //Arrange
        $post = BlogPost::factory()->make();

        $post->save();
        
        $this->assertDatabaseHas('blog_posts', $post->getAttributes());
        //Act
       $this->put("posts/{$post->id}", ['title' => 'updated title here', 'content' => 'Test Content updated'])->assertStatus(302)->assertSessionHas('status');

        $this->assertDatabaseHas('blog_posts', [ 'title' =>  'updated title here', 'content' => 'Test Content updated']);
        $this->assertEquals(session('status'), 'Blogpost updated successfully');
    }
    
    public function test_seeOneBlogPostDeleteFunction()
    {
        // $this->withoutExceptionHandling();
        //Arrange
        $post = BlogPost::factory()->make();

        $post->save();
        
        $this->assertDatabaseHas('blog_posts', $post->getAttributes());
        //Act
       $this->delete("posts/{$post->id}")->assertStatus(302);

        $this->assertDatabaseMissing('blog_posts', [ 'title' =>  'updated title here', 'content' => 'Test Content updated']);
    }
}
 