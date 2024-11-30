import type { BottomTabNavigationOptions } from "@react-navigation/bottom-tabs"
import { useNavigation } from "@react-navigation/native"
import { useEffect } from "react"
import { Text, View } from "react-native"

export default function HomeScreen() {
	const navigation = useNavigation()

	useEffect(() => {
		navigation.setOptions({
			headerSearchBarOptions: {},
		} satisfies BottomTabNavigationOptions)
	}, [navigation])

	return (
		<View>
			<Text>Home</Text>
		</View>
	)
}
