<?php

namespace App\Virtual\Models;

use App\Models\Category;
// use App\Models\Comment;
use App\Models\User;

/**
 * @OA\Schema(
 *     title="Post",
 *     description="Post model",
 *     @OA\Xml(
 *         name="Post"
 *     )
 * )
 */
class Post
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID of the post",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *      title="Title",
     *      description="Title of the post",
     *      example="A nice post"
     * )
     *
     * @var string
     */
    public $title;

    /**
     * @OA\Property(
     *      title="Content",
     *      description="Content of the post",
     *      example="This is the content of the post"
     * )
     *
     * @var string
     */
    public $content;

    /** @OA\Property(
     *      title="Category",
     *      description="Category of the post",
     *      example="PHP"
     * )
     *
     * @var Category
     */
    public $category;

    /** @OA\Property(
     *      title="Comments",
     *      description="Comments of the post",
     *      @OA\Schema(
     *          type="array",
     *          @OA\Items(
     *              ref="#/components/schemas/Comment"
     *          )
     *      )
     * )
     *
     * @var Comment[]
     */

    /** @OA\Property(
     *      title="Author",
     *      description="Author of the post",
     *      example={"id": 1, "name": "John Doe", "email": "john@example.com"}
     * )
     *
     * @var User
     */
    public $author;

    /** @OA\Property(
     *      title="Created At",
     *      description="Created at of the post",
     *      format="date-time",
     *      example="2023-01-01T00:00:00+00:00"
     * )
     *
     * @var string
     */
    // public $created_at;

    /** @OA\Property(
     *      title="Updated At",
     *      description="Updated at of the post",
     *      format="date-time",
     *      example="2023-01-01T00:00:00+00:00"
     * )
     *
     * @var string
     */
    public $updated_at;
}
