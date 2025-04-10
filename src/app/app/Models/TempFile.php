<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TempFile
{
    private string $disk = 'local';
    private readonly string $filepath;
    private readonly string $extension;
    private readonly string $mime_type;

    public function __construct(UploadedFile $file)
    {
        $this->disk = config('filesystems.default');
        $path = Storage::disk($this->disk)->put('images/temp_teams', $file) ?? null;

        if (Storage::disk($this->disk)->missing($path)) {
            throw new FileNotFoundException();
        }

        $this->filepath = Storage::disk('local')->put('images/teams', $file)?? '';
        $this->extension = $file->getClientOriginalExtension();
        $this->mime_type = Storage::mimeType($this->filepath);
    }

    /**
     * ファイルパス:DB保存
     *
     * @return string
     */
    public function path(): string
    {
        return $this->filepath;
    }

    /**
     * ファイルパス:画面表示
     *
     * @return string
     */
    public function pathFromBase64(): string
    {
        return "data:{$this->mime_type};base64," . base64_encode(Storage::get($this->filepath));
    }

    /**
     * 拡張子
     *
     * @return string
     */
    public function extension(): string
    {
        return $this->extension;
    }

    /**
     * mime_type
     *
     * @return string
     */
    public function mimeType(): string
    {
        return $this->mime_type;
    }

    /**
     * 削除
     *
     * @return boolean
     */
    public function delete(): bool
    {
        return Storage::disk($this->disk)->delete($this->path());
    }
}
