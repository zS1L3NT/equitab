import cn from "@/lib/cn"
import { useTheme } from "@react-navigation/native"
import { type ReactNode, useMemo, useState } from "react"
import { type GestureResponderEvent, Text, type TextStyle } from "react-native"
import { View } from "react-native"
import TouchableScale from "react-native-touchable-scale"

export type AppListItemProps = {
	title: string
	titleStyle?: TextStyle
	titleClassName?: string
	subtitle?: string | null
	subtitleStyle?: TextStyle
	subtitleClassName?: string
	leading?: ReactNode
	trailing?: ReactNode
	onPress?: (e: GestureResponderEvent) => void
}

type ExtraProps = {
	measurements: AppListMeasurements
	inset: boolean
	isLast: boolean
}

export type AppListMeasurements = Record<
	"SIZE" | "PADDING_HORIZONTAL" | "PADDING_VERTICAL" | "BORDER_SIZE" | "FLEX_GAP",
	number
>

export default function AppListItem({
	title,
	titleStyle,
	titleClassName,
	subtitle,
	subtitleStyle,
	subtitleClassName,
	leading,
	trailing,
	onPress,
	measurements,
	inset,
	isLast,
}: AppListItemProps & ExtraProps) {
	const theme = useTheme()

	const [isPressing, setIsPressing] = useState(false)
	const backgroundColor = useMemo(
		() => (isPressing ? theme.colors.background : theme.colors.card),
		[isPressing, theme.colors],
	)

	const { SIZE, PADDING_HORIZONTAL, PADDING_VERTICAL, BORDER_SIZE, FLEX_GAP } = measurements
	const HEIGHT = SIZE + PADDING_VERTICAL * 2

	return (
		<View
			className="relative"
			style={[
				{
					height: HEIGHT,
					backgroundColor: backgroundColor,
				},
				!isLast
					? {
							height: HEIGHT + BORDER_SIZE,
							borderBottomWidth: BORDER_SIZE,
							borderStyle: "solid",
							borderBottomColor: theme.colors.border,
						}
					: null,
			]}
		>
			{!isLast && (
				<View
					className="absolute left-0 bottom-[-1px] h-[1px]"
					style={{
						width: PADDING_HORIZONTAL + FLEX_GAP + (leading ? SIZE + FLEX_GAP : 0),
						backgroundColor: inset ? theme.colors.card : backgroundColor,
					}}
				/>
			)}
			<TouchableScale
				activeScale={inset ? 1 : 0.97}
				tension={10}
				onPressIn={() => setIsPressing(true)}
				onPressOut={() => setIsPressing(false)}
				onPress={onPress}
				disabled={!onPress}
				style={{ height: HEIGHT }}
			>
				<View
					className="flex flex-row items-center"
					style={{
						height: HEIGHT,
						gap: FLEX_GAP,
						paddingHorizontal: PADDING_HORIZONTAL + FLEX_GAP,
						paddingVertical: PADDING_VERTICAL,
					}}
				>
					{leading}
					<View>
						<Text
							className={cn("font-medium text-[17px]", titleClassName)}
							style={titleStyle}
						>
							{title}
						</Text>
						{subtitle && (
							<Text
								className={cn("text-gray-500", subtitleClassName)}
								style={subtitleStyle}
							>
								{subtitle}
							</Text>
						)}
					</View>
					{trailing}
				</View>
			</TouchableScale>
		</View>
	)
}
