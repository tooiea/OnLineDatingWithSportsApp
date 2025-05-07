<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TempFile
{
    private string $disk = 'local';
    private string $temp_dir;
    private string $official_dir;

    private string $filepath;
    private readonly string $extension;
    private readonly string $mime_type;

    /**
     * Undocumented function
     *
     * @param UploadedFile $file
     * @param string $tempDir
     * @param string $officialDir
     */
    public function __construct(UploadedFile $file, string $tempDir = 'images/temp_teams', string $officialDir = 'images/teams')
    {
        $this->disk = config('filesystems.default');
        $this->temp_dir = $tempDir;
        $this->official_dir = $officialDir;
        $path = Storage::disk($this->disk)->put($this->temp_dir, $file) ?? null;

        if (Storage::disk($this->disk)->missing($path)) {
            throw new FileNotFoundException();
        }

        $this->filepath = $path ?? '';
        $this->extension = $file->getClientOriginalExtension();
        $this->mime_type = Storage::mimeType($path);
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

    /**
     * 仮保存ディレクトリから正式ディレクトリへ移動
     * パスを更新する
     *
     * @return void
     */
    public function moveTo()
    {
        $movePath = str_replace($this->temp_dir, $this->official_dir, $this->path());
        Storage::disk($this->disk)->move($this->path(), $movePath);
        $this->filepath = $movePath;
    }
}
