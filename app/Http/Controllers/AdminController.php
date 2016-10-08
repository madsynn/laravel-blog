<?php

namespace App\Http\Controllers;

use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\CommentRepository;
use App\Http\Repositories\ImageRepository;
use App\Http\Repositories\MapRepository;
use App\Http\Repositories\PageRepository;
use App\Http\Repositories\PostRepository;
use App\Http\Repositories\TagRepository;
use App\Http\Repositories\UserRepository;
use App\Map;
use App\Page;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $postRepository;
    protected $commentRepository;
    protected $userRepository;
    protected $tagRepository;
    protected $categoryRepository;
    protected $pageRepository;
    protected $imageRepository;

    /**
     * AdminController constructor.
     * @param PostRepository $postRepository
     * @param CommentRepository $commentRepository
     * @param UserRepository $userRepository
     * @param CategoryRepository $categoryRepository
     * @param TagRepository $tagRepository
     * @param PageRepository $pageRepository
     * @param ImageRepository $imageRepository
     * @internal param MapRepository $mapRepository
     */
    public function __construct(PostRepository $postRepository,
        CommentRepository $commentRepository,
        UserRepository $userRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        PageRepository $pageRepository,
        ImageRepository $imageRepository) {
        $this->postRepository     = $postRepository;
        $this->commentRepository  = $commentRepository;
        $this->userRepository     = $userRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository      = $tagRepository;
        $this->pageRepository     = $pageRepository;
        $this->imageRepository    = $imageRepository;
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $info                   = [];
        $info['post_count']     = $this->postRepository->count();
        $info['comment_count']  = $this->commentRepository->count();
        $info['user_count']     = $this->userRepository->count();
        $info['category_count'] = $this->categoryRepository->count();
        $info['tag_count']      = $this->tagRepository->count();
        $info['page_count']     = $this->pageRepository->count();
        $info['image_count']    = $this->imageRepository->count();

        return view('admin.index', compact('info'));
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function saveSettings(Request $request)
    {
        $inputs = $request->except('_token');
        foreach ($inputs as $key => $value) {
            $map = Map::firstOrNew([
                'key' => $key
            ]);
            $map->tag   = 'settings';
            $map->value = $value;
            $map->save();
        }
        cache()->tags(MapRepository::$tag)->flush();
        return back()->with('success', 'Success');
    }

    public function posts()
    {
        $posts = $this->postRepository->pagedPostsWithoutGlobalScopes();
        return view('admin.posts', compact('posts'));
    }

    public function comments()
    {
        $comments = $this->commentRepository->getAll();
        return view('admin.comments', compact('comments'));
    }

    public function tags()
    {
        $tags = $this->tagRepository->getAll();
        return view('admin.tags', compact('tags'));
    }

    public function categories()
    {
        $categories = $this->categoryRepository->getAll();
        return view('admin.categories', compact('categories'));
    }

    public function users()
    {
        $users = User::paginate(20);
        return view('admin.users', compact('users'));
    }

    public function pages()
    {
        $pages = Page::paginate(20);
        return view('admin.pages', compact('pages'));
    }
}
