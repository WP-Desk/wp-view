<?php


use WPDesk\View\Resolver\Exception\CanNotResolve;

class TestChainResolver extends \PHPUnit\Framework\TestCase
{
    const RESPONSE_OF_FIRST_RESOLVER = 'first';
    const RESPONSE_OF_SECOND_RESOLVER = 'second';

    const RESOLVE_METHOD_NAME = 'resolve';

    public function testUseSecondResolverWhenFirstFailed()
    {
        $firstResolver  = Mockery::mock(\WPDesk\View\Resolver\Resolver::class)
                                 ->shouldReceive(self::RESOLVE_METHOD_NAME)
                                 ->andThrowExceptions([CanNotResolve::class]);
        $secondResolver = Mockery::mock(\WPDesk\View\Resolver\Resolver::class)
                                 ->shouldReceive(self::RESOLVE_METHOD_NAME)
                                 ->andReturn(self::RESPONSE_OF_SECOND_RESOLVER);

        $resolver = new \WPDesk\View\Resolver\ChainResolver($firstResolver, $secondResolver);
        $this->assertEquals(self::RESPONSE_OF_SECOND_RESOLVER, $resolver->resolver('whatever'));
    }

    public function testUseFirstResolverFirst()
    {
        $firstResolver = Mockery::mock(\WPDesk\View\Resolver\Resolver::class)
                                ->shouldReceive(self::RESOLVE_METHOD_NAME)
                                ->andReturn(self::RESPONSE_OF_FIRST_RESOLVER);

        $secondResolver = Mockery::mock(\WPDesk\View\Resolver\Resolver::class)
                                 ->shouldReceive(self::RESOLVE_METHOD_NAME)
                                 ->andThrowExceptions([CanNotResolve::class]);

        $resolver = new \WPDesk\View\Resolver\ChainResolver($firstResolver, $secondResolver);
        $this->assertEquals(self::RESPONSE_OF_SECOND_RESOLVER, $resolver->resolver('whatever'));
    }

    public function testThrowExceptionWhenBothCannotFind()
    {
        $this->expectException(CanNotResolve::class);

        $firstResolver  = Mockery::mock(\WPDesk\View\Resolver\Resolver::class)
                                 ->shouldReceive(self::RESOLVE_METHOD_NAME)
                                 ->andThrowExceptions([CanNotResolve::class]);

        $secondResolver = Mockery::mock(\WPDesk\View\Resolver\Resolver::class)
                                 ->shouldReceive(self::RESOLVE_METHOD_NAME)
                                 ->andThrowExceptions([CanNotResolve::class]);

        $resolver = new \WPDesk\View\Resolver\ChainResolver($firstResolver, $secondResolver);

        $resolver->resolve('whatever2');
    }
}